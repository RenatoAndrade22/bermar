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
                    'cloud_name' => env('IMAGE_CLOUD_NAME'),
                    'api_key'    => env('IMAGE_API_KEY'),
                    'api_secret' => env('IMAGE_SECRET'),
                ],
            ]
          );
  
          return ($cloudinary->uploadApi())->upload($file_name);
    }

    static function delete($publicId)
    {
        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('IMAGE_CLOUD_NAME'),
                    'api_key'    => env('IMAGE_API_KEY'),
                    'api_secret' => env('IMAGE_SECRET'),
                ],
            ]
        );

        // Excluindo a imagem usando o public ID
        $cloudinary->uploadApi()->destroy($publicId);

        return response()->json(['message' => 'Imagem excluída com sucesso!']);
    }

}
