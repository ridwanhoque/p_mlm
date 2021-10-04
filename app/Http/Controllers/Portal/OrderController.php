<?php

namespace App\Http\Controllers\Portal;

use App\Models\{Order, User};
use App\Http\Controllers\Controller;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\{Request, Response};
use App\Http\Requests\Portal\OrderCreateRequest;
use Illuminate\Contracts\Routing\ResponseFactory;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return view('portal.order.index', [
            'orders' => $user->orders()->latest()->paginate()
        ]);
    }

    /**
     * @param OrderCreateRequest $request
     * @return ResponseFactory|Response
     */
    public function store(OrderCreateRequest $request)
    {
        if(CartFacade::isEmpty()){
            abort(406);
        }
        $request->placeOrder();

        CartFacade::clear();
        CartFacade::clearCartConditions();

        return response([
            'message' => 'Order placed.'
        ]);
    }

    public function show(Order $order)
    {
        abort_unless($order->isItOwner(), 401);

        $order->load(['items.orderable' => function(MorphTo $query){
            $query->withoutGlobalScope('publish');
        }]);

        return view('portal.order.show', compact('order'));
    }
}
