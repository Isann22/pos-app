<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoboFlowContoller extends Controller
{

    public function liveDetection()
    {
        $url = "https://demo.roboflow.com/" . env('ROBOFLOW_MODEL_ID') . "?publishable_key=" . env('ROBOFLOW_API_KEY');
        return redirect()->away($url);
    }
}
