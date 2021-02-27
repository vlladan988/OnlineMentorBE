<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemplateMeal;
use App\Models\Template;
use DB;


class TemplateMealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $templateId = $request->templateId;
        $template = Template::find($templateId);
        $trainer = auth('api-trainer')->user();

        TemplateMeal::create([
            'template_id' => $templateId,
            'name' => $request->name,
            'description' => $request->description,
            'sort_number' => count($template->templateMeals) + 1
        ]);

        return $this->show($templateId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $responseData = [];
        // $trainer = auth('api-trainer')->user();
        // $template = Template::where('id', $id)->where('trainer_id', $trainer->id)->first();
        $template = Template::find($id);

        foreach($template->templateMeals as $meals){
            $meals->recipes;
            array_push($responseData, $meals);
        }

        return response()->json($responseData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editMealOrder(Request $request)
    {
        $trainer = auth('api-trainer')->user();
        $orderList = $request->orderList;
        $meals = TemplateMeal::where('template_id', $request->templateId)->get();


        for ($i = 0; $i < count($meals); $i++){
            $meals[$i]->sort_number = $orderList[$i];
            $meals[$i]->save();
        }

        return $this->show($request->templateId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $templateMeal = TemplateMeal::find($id);
        $templateId = $request->templateId;

        $templateMeal->name = $request->name;
        $templateMeal->description = $request->description;

        $templateMeal->save();

        return $this->show($templateId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $templateMeal = TemplateMeal::find($id);
        DB::table('templatemeal_recipe')->where('meal_id', $id)->delete();

        $templateMeal->delete();

        return $this->show($templateMeal->template->id);

    }
}
