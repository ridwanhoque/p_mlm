<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function destroy(Image $image)
    {
        $image->delete();

        return delete_response();
    }
}
