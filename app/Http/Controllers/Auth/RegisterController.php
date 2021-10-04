<?php

namespace App\Http\Controllers\Auth;

use App\Models\PromotionalDesignation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\ValidPhoneNumber;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\{Hash, Validator};

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'unique:users', new ValidPhoneNumber()],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => 'nullable|in:registered-user,unregistered-user,general-user',
            'date_of_birth' => 'required|date:Y-m-d',
            'present_address' => 'required',
            'nid_image' => 'image',
            'reference_id' => 'nullable|exists:users,id'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        /** @var User $user */
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'general',
            'reference_id' => $data['reference_id'],
            'district_id' => $data['district_id'] ?? null,
        ]);

        foreach ([
                'father_name', 'date_of_birth', 'age', 'nid_number',
                     'present_address', 'bkash_number', 'spacial_note'
                 ] as $field){
            $user->metas()->create([
                'key' => $field,
                'value' => $data[$field] ?? null
            ]);
        }

        if(array_key_exists('nid_image', $data)){
            $user->metas()->create([
                'key' => 'nid_image',
                'value' => $data['nid_image']->store(file_path())
            ]);
        }

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param Request $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return [
            'message' => 'Done!'
        ];
    }

}
