<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product, Package, User};
use Illuminate\Support\Str;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return view('wishlist.index', [
            'wishlistProducts' => $user->wishlistProducts()->with('firstImage')->get(),
            'wishlistPackages' => $user->wishlistPackages()->with('firstImage')->get()
        ]);
    }

    public function store($itemId, $itemClass, Request $request)
    {
        $this->user()->{'wishlist'.Str::plural($itemClass)}()->syncWithoutDetaching(
            $this->getItem($itemId, $itemClass)
        );

        return create_response([
            'message' => 'This item added on your wishlist.'
        ]);
    }

    public function destroy($itemId, $itemClass, Request $request)
    {
        $item = $this->getItem($itemId, $itemClass);

        $this->user()->{'wishlist'.Str::plural($itemClass)}()->detach($item);

        return back()->withMessage('Item removed.');
    }

    protected function getItem($itemId, $itemClass)
    {
        $itemClass = "App\Models\\{$itemClass}";

        return $itemClass::findOrFail($itemId);
    }

    protected function user() : User
    {
        return auth()->user();
    }
}
