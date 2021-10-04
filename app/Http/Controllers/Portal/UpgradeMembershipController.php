<?php

namespace App\Http\Controllers\Portal;

use App\Http\Requests\Portal\UpgradeMembershipRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpgradeMembershipController extends Controller
{
    public function edit()
    {
        return view('portal.user.upgrade-membership');
    }

    public function update(UpgradeMembershipRequest $request)
    {
        $request->upgrade();

        return update_response([
            'default' => false
        ]);
    }
}
