<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\TemplateMeal;
use App\Models\Recipe;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use DB;


class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth('api-trainer')->user();
        // $responseData = [];

        foreach($user->templates as $template){
            if($template->template_image_url)
                $template->template_image_url = storage_path('app/public/TemplateImage/' . $template->template_image_url);
            // array_push($responseData, $template);
        }
        

        return response()->json($user->templates);
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
        $trainer = auth('api-trainer')->user();

        $templateImage = $request->imageUrl;

        if($templateImage){
            $image = str_replace('data:image/png;base64,', '', $templateImage);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(15).'.'.'png';
            Storage::disk('local')->put("public/TemplateImage/" . $imageName, base64_decode($templateImage));
            $templateImage = $imageName;
        }

        $template = Template::create([
            'trainer_id' => $trainer->id,
            'name' => $request->name,
            'template_image_url' => $templateImage,
            'template_meal_type' => $request->mealType,
            'template_description' => $request->description,
            'template_duration' => $request->duration,
        ]);

        return $this->index();
        // return response()->json($template);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clientTemplates = Client::find($id)->templates;
        foreach($clientTemplates as $template){
            $template->templateMeals;
            if($template->template_image_url)
                $template->template_image_url = storage_path('app/public/TemplateImage/' . $template->template_image_url);

            foreach($template->templateMeals as $meal){
                $meal->recipes;
                foreach($meal->recipes as $recipe){
                    $recipe->recipeGroceries;
                }
            }
        }

        return response()->json($clientTemplates);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $template = Template::find($id);
        $templateImage = $request->imageUrl;

        $template->name = $request->name;

        if($request->isImageChanged){
            if($template->template_image_url !== null ){
                unlink(storage_path('app/public/TemplateImage/' . $template['template_image_url']));
            }

            $image = str_replace('data:image/png;base64,', '', $templateImage);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(15).'.'.'png';
            Storage::disk('local')->put("public/TemplateImage/" . $imageName, base64_decode($templateImage));
            $templateImage = $imageName;
            $template->template_image_url = $imageName;
        }
        $template->template_meal_type = $request->mealType;
        $template->template_description = $request->description;
        $template->template_duration = $request->duration;
        $template->save();

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trainer = auth('api-trainer')->user();

        $template = Template::where('id', $id)->where('trainer_id', $trainer->id)->first();
        if($template->template_image_url){
            unlink(storage_path('app/public/TemplateImage/' . $template['template_image_url']));
        }

        foreach($template->templateMeals as $meal){
            DB::table('templatemeal_recipe')->where('meal_id', $meal->id)->delete();
            $meal->delete();
        }
        
        DB::table('client_template')->where(['template_id' => $template->id])->delete();
        $template->delete();

        return $this->index();
    }

    public function assignToClient(Request $request){
        $templateId = $request->templateId;
        $clientId = $request->clientId;

        $template = Template::find($templateId);
        $client = Client::find($clientId);

        $isTemplateAssigned = DB::table('client_template')->where('client_id', $clientId)->get();

        if(count($isTemplateAssigned)) 
            return response()->json(['error'=> 'Template already assigned to client'], 500);   


        DB::table('client_template')->insert(['template_id' => $templateId, 'client_id' => $clientId]);

        return response()->json(['template' => $template->name, 'client' => $client->full_name]);


    }

    public function unassignFromClient(Request $request){
        
        $clientId = $request->clientId;

        DB::table('client_template')->where('client_id', $clientId)->delete();

        return response()->json(['ok'=> 'Template unassigned'], 200);
    }
}
