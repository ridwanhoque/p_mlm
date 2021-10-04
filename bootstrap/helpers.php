<?php

use Illuminate\Support\Facades\Storage;

function create_response($options = [])
{
    return response(
        array_merge([
            'message' => 'Created!',
            'default' => true
        ], $options)
    );
}

function update_response($options = [])
{
    return response(array_merge([
        'message' => 'Updated!',
        'default' => true
    ], $options));
}

function delete_response($options = [])
{
    return response([
            'message' => 'Deleted!',
            'default' => true
        ] + $options
    );
}

function file_path($name = null)
{
    $directory =  date('F') . DIRECTORY_SEPARATOR . date('Y');

    Storage::makeDirectory($directory);

    if($name){
        return $directory.DIRECTORY_SEPARATOR.ltrim($name, '/');
    }

    return $directory;
}

if (!function_exists('percentage_of')){

    function percentage_of($percent, $total)
    {
        return ($percent / 100) * $total;
    }
}



