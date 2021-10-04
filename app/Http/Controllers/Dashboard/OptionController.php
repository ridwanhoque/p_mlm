<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\OptionResource;
use App\Models\Option;
use App\Repositories\OptionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class OptionController extends Controller
{
    public function index()
    {
        return OptionResource::collection(
            Option::all()->makeOption()
        );
    }

    public function update(Request $request, OptionRepository $optionRepository)
    {
        foreach ($request->get('text', []) as $option_key => $option_value){
            /** @var Option $option */
            $option = Option::where('option_key', $option_key);

            if(is_null($option->first())){
                Option::create([
                    'option_key' => $option_key,
                    'option_value' => $option_value
                ]);
            }else{
                $option->update(['option_value' => $option_value]);
            }
        }

        /** @var UploadedFile $file */
        foreach ($request->file('files', []) as $option_key => $file)  {
            /** @var Option $option */
            $option = Option::where('option_key', $option_key)->first();

            if(is_null($option)){
                Option::create([
                    'option_key' => $option_key,
                    'option_value' => $file->store(file_path())
                ]);
            }else{
                $file->storeAs(dirname($option->option_value), basename($option->option_value));
            }
        }

        $optionRepository->forgetCache();

        return update_response();
    }
}
