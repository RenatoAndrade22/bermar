<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;

class UploadCloudController extends Controller
{
    static function upload($file_name){

        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => 'dk7eeb3y6',
                    'api_key'    => '968423785681561',
                    'api_secret' => 'mLtuAD12CKYp2IyRVKlrr9ugfes',
                ],
            ]
          );
  
          return ($cloudinary->uploadApi())->upload($file_name);
    }
}
