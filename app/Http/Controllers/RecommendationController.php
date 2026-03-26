<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plat;
use App\Services\PlatRecommendationService;
use App\Models\Recommendation;
use App\Jobs\AnalyzeRecommendation;

class RecommendationController extends Controller
{
    public function analyze(Request $request , Plat $id){
        $plat = $id;
        $user = $request->user();

        $recommendation = Recommendation::create([
            'user_id' => $user->id,
            'plat_id' => $plat->id,
            'status' => 'processing'
        ]);

        AnalyzeRecommendation::dispatch(
            $recommendation->id,
            $user->id,
            $plat->id
        )->onQueue('ai');

        return response()->json([
            "message" => "you request has resived please wait the response",
            'recommendation' => $recommendation
        ]);

    }

    public function show(Request $request , Plat $id){
        $plat = $id;

        $recommendation = Recommendation::where('plat_id' , $plat->id)->where('user_id' , $request->user()->id)->latest()->first();
        return response()->json([
            "message" => "this is the response of ai",
            'plat' => $plat,
            'recommendation' => $recommendation
        ]);
    }

    public function history(Request $request){
        $plats = Plat::with('recommendations')->whereHas('recommendations', function ($query) use ($request) {
        $query->where('user_id', $request->user()->id);
            })
        ->get();
        return response()->json([
            "message" => "this is all responses from ai",
            'recommendations' => $plats
        ]);
    }
}
