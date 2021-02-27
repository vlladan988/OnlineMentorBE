<?php

namespace App\Http\Controllers;

use App\Models\DailyMeal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Client;

class DailyMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->show($request->clientId, Carbon::parse($request->date));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $client = Client::find($request->clientId);
        $dailyMeal = DailyMeal::create([
            'client_id' => $request->clientId,
            'name' => $request->name,
            'date' => Carbon::parse($request->date)
        ]);

        // return response()->json($dailyMeal);
        return $this->show($request->clientId, Carbon::parse($request->date));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function show($clientId, $date)
    {
        $dailyMails = DailyMeal::where('client_id', $clientId)->where('date', Carbon::parse($date))->get();

        return response()->json($dailyMails);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyMeal $dailyMeal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyMeal $dailyMeal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyMeal  $dailyMeal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $dailyMeal = DailyMeal::find($request->mealId)->delete();
        
    }
}
