<?php

namespace App\Http\Requests\Portal;

use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\{CommissionHand, Order, OrderItem, Package, User};
use Illuminate\Support\Str;

class OrderCreateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasBalance(CartFacade::getTotal());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shipping_address' => 'required',
            'district_id' => 'required|exists:districts,id'
        ];
    }

    /**
     *Placing a new order
     */
    public function placeOrder()
    {
        $total = CartFacade::getTotal();

        $totalCommission = array_reduce(CartFacade::getContent()->toArray(), function ($carry, $product){
            return ($carry + $product['attributes']['commission']);
        }, 0);

        /** @var User $user */
        $user = $this->user();

        $attributes = $this->only('shipping_address', 'district_id');

        DB::transaction(function () use($attributes, $total, $user, $totalCommission){
            /**
             * Create Order
             */
            /** @var Order $order */
            $order = $user->orders()->create(array_merge($attributes, [
                    'total' => $total,
                    'total_commission' => $totalCommission
                ]
            ));
            /**
             * Distribute Commission
             */
            $this->distributeCommission($order);
            /**
             * Save own commission
             */
            $this->saveOnWallet($order);
            /**
             * Creating Order Items
             */
            foreach (CartFacade::getContent() as $item){

                /** @var OrderItem $orderItem */
                $orderItem = $order->items()->create([
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'orderable_id' => $item->attributes->item_id,
                    'orderable_type' => 'App\Models\\' . $item->attributes->item_class
                ]);
                if($item->attributes->item_class == 'Package'){
                    /** @var Package $package */
                    $package = Package::find($item->attributes->item_id);
                    /**
                     * Create Package Products
                     */
                    foreach ($package->products as $product){

                        $orderItem->packageProducts()->forceCreate([
                            'product_id' => $product->id,
                            'package_id'=> $package->id
                        ]);
                    }
                }

                if($item->attributes->is_emi){
                    $now = now();

                    foreach ($orderItem->orderable->emi->installments as $index => $installment){
                        $orderItem->installments()->create([
                            'duration' => $index == 0 ? 'On purchase' : $this->daysInterval($orderItem->orderable->emi->installment_interval),
                            'name' => $installment->name,
                            'payment_date' => $now->format('Y-m-d'),
                            'installment_amount' => $installment->installment,
                            'commission' => $installment->commission,
                        ]);

                        $now->addDays($orderItem->orderable->emi->installment_interval);
                    }
                }
            }
        });
    }

    protected function daysInterval($day)
    {
        return $day . ' '. Str::plural('Day', $day);
    }

    /**
     * @param Order $order
     */
    public function saveOnWallet(Order $order)
    {
        $order->wallets()->create([
            'amount' => -$order->total,
            'transaction_type' => 'out',
            'is_processed' => 1,
            'processed_by' => auth()->id()
        ]);

        (new WalletRepository())->forgetUserWallet();
    }

    /**
     * @param Order $order
     */
    protected function distributeCommission(Order $order)
    {
        /** @var User $user */
        $user = $this->user();

        if($user->hasReference() && $order->total_commission){
            $commissionHands = CommissionHand::all();

            $users = $user->parents()->take($commissionHands->count())->get();
            /** @var User $defaultUser */
            $defaultUser = User::query()->whereNull('reference_id')->first();

            foreach ($commissionHands as $key => $commissionHand){
                /** @var User $commissionUser */
                $commissionUser = null;

                if($users->has($key)){

                    $commissionUser = $users[$key];
                }else{
                    $commissionUser = $defaultUser;
                }

                $commissionUser->commissions()->create([
                    'amount' => percentage_of($commissionHand->commission, $order->total_commission),
                    'commission_from_type' => Order::class,
                    'commission_from_id' => $order->id,
                ]);
            }
        }
    }
}
