<?php

namespace App\Http\Controllers;

use App\Services\RoboflowService;
use Illuminate\Http\Request;

class RoboFlowContoller extends Controller
{
    public function showForm()
    {
        return view('detect');
    }

    public function process(Request $request, RoboflowService $roboflow)
    {
        $request->validate([
            'image' => 'required|image|max:5000'
        ]);

        $results = $roboflow->detect(
            $request->file('image')->getRealPath()
        );

        return response()->json(['data' => $results]);
    }


    public function liveDetection()
    {
        $url = "https://demo.roboflow.com/" . env('ROBOFLOW_MODEL_ID') . "?publishable_key=" . env('ROBOFLOW_API_KEY');
        return redirect()->away($url);
    }
}
