<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletListResource;
use Illuminate\Http\Resources\{Json\AnonymousResourceCollection};

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return WalletListResource::collection(
            Wallet::with('user')->withoutGlobalScope('processed')->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Wallet $wallet
     * @return WalletResource|Response
     */
    public function show($wallet)
    {
        $wallet = Wallet::with('walletable')
            ->withoutGlobalScope('processed')->findOrFail($wallet);


        return new WalletResource($wallet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Wallet $wallet
     * @return Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wallet $wallet
     * @return Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
