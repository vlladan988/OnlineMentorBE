<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Goal;

class GoalController extends Controller
{
    public function show(Request $request, $id){
        
        $goal = Goal::where('client_id', $id)->first();
        return response()->json($goal);
    }

    public function update(Request $request, $id){
        $goal = Goal::where('client_id',$id)->first();

        $goal->final_weight = $request->goalWeight;
        $goal->description = $request->description;
        $goal->start_at = Carbon::parse($request->currentTime);
        $goal->end_at = Carbon::parse($request->goalTime);
        $goal->save();

        return response()->json($goal);
    }
}
