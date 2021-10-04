<?php

namespace App\Http\Controllers\Portal;

use App\Http\Requests\Portal\UpdateUserRequest;
use App\Http\Resources\Web\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('portal.profile.edit');
    }

    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function update(UpdateUserRequest $request)
    {
        $request->update();

        return update_response();
    }
}
