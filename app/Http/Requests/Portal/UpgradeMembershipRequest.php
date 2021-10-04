<?php

namespace App\Http\Requests\Portal;

use Illuminate\Foundation\Http\FormRequest;

class UpgradeMembershipRequest extends FormRequest
{
    protected $commonRules = [
        
    ];

    protected $stepRules = [
        [
            'first_name' => 'required',
            'last_name' => 'required',
            'files.profile_photo' => 'image',
            'meta.father_name' => 'required',
            'meta.date_of_birth' => 'required',
            'meta.age' => 'required',
            'meta.gender' => 'required',
            'meta.nid_number' => 'required',
            'meta.nid_image' => 'image',
            'meta.permanent_address' => 'required',
            'meta.present_address' => 'required',
            'phone_number' => 'required',
            'meta.bkash_number' => 'required',
            'email' => 'required|email',
            'meta.bank_account_name' => 'required',
            'meta.bank_account_number' => 'required',
            'meta.bank_name' => 'required',
            'meta.bank_branch' => 'required',
            'meta.next_kin_name' => 'required',
            'meta.next_kin_relation' => 'required',
            'meta.next_kin_phone_number' => 'required',
            'meta.nominee_name' => 'required',
            'meta.nominee_relation' => 'required',
            'meta.nominee_phone_number' => 'required',
            'meta.nominee_image' => 'image',
        ],[

        ],[

        ]
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->commonRules, $this->stepRules[$this->step]);
    }

    public function upgrade()
    {

    }

}
