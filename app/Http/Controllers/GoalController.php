<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Goal;

class GoalController extends Controller
{
    public function index(Request $request){
        
        $goal = Goal::where('client_id',$request->id)->get();

        return response()->json($goal[0]);
    }

    public function update(Request $request){
        $goal = Goal::where('client_id',$request->id)->first();

        $goal->current_weight = $request->currentWeight;
        $goal->final_weight = $request->goalWeight;
        $goal->description = $request->description;
        $goal->start_at = Carbon::parse($request->currentTime);
        $goal->end_at = Carbon::parse($request->goalTime);
        $goal->save();

        return response()->json($goal);
    }
}
