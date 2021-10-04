<?php

namespace App\Http\Controllers;

use App\Rules\ValidateOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new ValidateOldPassword()],
            'password' => 'required|min:6|confirmed'
        ]);

        $request->user()->update([
                'password' => Hash::make($request->password)
            ]
        );

        return update_response();
    }
}
