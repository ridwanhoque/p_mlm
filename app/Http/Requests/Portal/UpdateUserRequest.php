<?php

namespace App\Http\Requests\Portal;

use App\Models\User;
use App\Rules\ValidPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->additionalRules(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'meta.date_of_birth' => 'required|date:Y-m-d',
            'meta.present_address' => 'required',
            'phone_number' => ['required', 'unique:users,phone_number,' . $this->user()->id, new ValidPhoneNumber()],
            'email' => ['required', 'email', 'unique:users,email,' . $this->user()->id],
        ]);
    }

    public function update()
    {
        /** @var User $user */
        $user = $this->user();

        foreach ($this->get('meta', []) as $key => $mata){
            $user->metas()->updateOrCreate([
                'key' => $key
            ], [
                'value' => $mata
            ]);
        }

        foreach (['profilePhoto', 'nidImage', 'nomineeImage'] as $image) {
            if(!$this->hasFile('files.'.Str::snake($image))){
                continue;
            }
            $this->{$image}();
        }
    }

    protected function additionalRules()
    {
        if($this->user()->isRegisteredMember()){
            return [
                'files.profile_photo' => 'image',
                'meta.father_name' => 'required',
                'meta.age' => 'required',
                'meta.gender' => 'required|in:Male,Female',
                'meta.nid_number' => 'required',
                'files.nid_image' => 'image|max:700',
                'meta.permanent_address' => 'required',
                'meta.present_address' => 'required',
                'meta.bkash_number' => ['required', new ValidPhoneNumber()],
                'meta.bank_account_name' => ['required'],
                'meta.bank_account_number' => ['required'],
                'meta.bank_name' => ['required'],
                'meta.bank_branch' => ['required'],
                'meta.next_kin_name' => ['required'],
                'meta.next_kin_relation' => ['required'],
                'meta.next_kin_phone_number' => ['required'],
                'meta.nominee_name' => ['required'],
                'meta.nominee_relation' => ['required'],
                'meta.nominee_phone_number' => ['required'],
                'files.nominee_image' => ['image'],
            ];
        }

        return [];
    }

    protected function profilePhoto()
    {
        $fullName = $this->getImageHashName('profile_photo');

        $this->updatePhoto($fullName, 'profile_photo');

        Image::make($this->file('files.profile_photo'))
            ->resize(200, 250)
            ->save('uploads/' . $fullName);
    }

    protected function nomineeImage()
    {
        $name = $this->getImageHashName('nominee_image');

        $this->updatePhoto($name, 'nominee_image');

        Image::make($this->file('files.nominee_image'))
            ->resize(200, 250)
            ->save('uploads/' . $name);
    }

    protected function nidImage()
    {
        $name = $this->getImageHashName('nid_image');

        $this->updatePhoto($name, 'nid_image');

        $this->file('files.nid_image')->storeAs(dirname($name), basename($name));
    }

    protected function getImageHashName($imageName)
    {
        if($this->user()->meta->get($imageName)){
            return $this->user()->meta->get($imageName);
        }

        return file_path($this->file('files.'.$imageName)->hashName());
    }

    protected function updatePhoto($name, $key)
    {
        $this->user()->metas()->updateOrCreate([
            'key' => $key
        ], [
            'value' => $name
        ]);
    }
}
