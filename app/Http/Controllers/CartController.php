<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Option, District};
use App\Contracts\ShouldUseInCart;
use Darryldecode\Cart\{Facades\CartFacade as Cart, CartCondition, Exceptions\InvalidConditionException};

class CartController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('ajax')){
            return [
                'content' => Cart::getContent(),
                'total' => Cart::getTotal(),
                'subtotal' => Cart::getSubTotal()
            ];
        }

        return view('cart.index');
    }

    /**
     * @param $itemFull
     * @param Request $request
     * @return array
     */
    public function store($itemFull, Request $request)
    {
        list($itemType, $itemId) = explode('_', $itemFull);

        $itemClass = "App\Models\\$itemType";

        /** @var ShouldUseInCart $item */
        $item = $itemClass::findOrFail($itemId);

        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);
        $emi = $request->get('emi', false);

        $item = Cart::add($itemFull, $item->name, $item->price(false, $emi), $request->quantity, [
            'photo' => $item->firstImagePath(),
            'permalink' => $item->permalink(),
            'item_id' => $itemId,
            'item_class' => $itemType,
            'delivery_in_dhaka' => $item->deliveryPriceDhaka(),
            'delivery_out_dhaka' => $item->deliveryPriceOutDhaka(),
            'commission' => $item->commission($emi),
            'is_emi' => $emi
        ]);

        return [
            'item' => $item,
            'total' => Cart::getTotal(),
            'subtotal' => Cart::getSubTotal(),
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {
        $request->validate([
            'product' => 'required',
            'product.*.quantity' => 'required|numeric|min:1'
        ]);

        foreach ($request->get('product', []) as $id => $item){

            Cart::update($id, array(
                'quantity' => [
                    'relative' => false,
                    'value' => $item['quantity']
                ],
            ));
        }

        return [
            'content' => Cart::getContent(),
            'subtotal' => Cart::getSubTotal(),
            'total' => Cart::getTotal()
        ];
    }

    public function remove($id)
    {
        Cart::remove($id);

        return [
            'message' => 'Done!',
            'default' => false,
            'total' => Cart::getTotal(),
            'subtotal' => Cart::getSubTotal(),
        ];
    }

    /**
     * @param District $district
     * @return array
     * @throws InvalidConditionException
     */
    public function setDistrict(District $district)
    {
        $options = Option::whereIn('option_key', ['delivery_inside_dhaka', 'delivery_outside_dhaka'])
            ->get()->makeOption();

        $deliveryCharge = $options->getOption('delivery_inside_dhaka', 0);

        if($district->isOutsideDhaka()){
            $deliveryCharge = $options->getOption('delivery_outside_dhaka', 0);
        }

        foreach (Cart::getContent() as $key => $item){

            $charge = $item->attributes->delivery_in_dhaka;

            if($district->isOutsideDhaka()){
                $charge = $item->attributes->delivery_out_dhaka;
            }
            Cart::update($key, [
                'conditions' => $this->deliveryProductCartCondition($item->quantity, $charge)
            ]);
        }

        Cart::condition(
            new CartCondition([
                'name' => 'Delivery Charge',
                'type' => 'delivery_charge',
                'target' => 'total',
                'value' => '+' . $deliveryCharge
            ])
        );

        return [
            'content' => Cart::getContent(),
            'subtotal' => Cart::getSubTotal(),
            'total' => Cart::getTotal()
        ];
    }

    /**
     * @param $quantity
     * @param $amount
     * @return CartCondition
     * @throws InvalidConditionException
     */
    protected function deliveryProductCartCondition($quantity, $amount)
    {
        return new CartCondition([
            'name' => 'Additional Product Delivery Charge',
            'type' => 'product_delivery_charge',
            'target' => 'total',
            'value' => '+' . ($amount * $quantity)
        ]);
    }
}
