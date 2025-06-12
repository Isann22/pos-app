<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RoboflowService
{
  public function detect($imagePath)
  {
    $response = Http::post('https://serverless.roboflow.com/deteksi-uang-rupiah-x79rd/1?', [
      'image' => base64_encode(file_get_contents($imagePath)),
    ], [
      'api_key' => '1eiRq97Cuje15JQdd0GS'
    ]);

    return $response->json();
  }
}
