<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Trainer; 
use App\Models\Client; 
use App\Models\Goal;
use App\Models\Gallery;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trainer = auth('api-trainer')->user();

        return response()->json($trainer->clients);
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
        $validator = Validator::make($request->all(), [ 
            'full_name' => 'required', 
            'email' => 'required|unique:trainers|unique:clients|email', 
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
                return response()->json(['error'=>$validator->errors()], 422);            
            }

        $trainer = auth('api-trainer')->user();
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $input['trainer_id'] = $trainer->id; 
        if($trainer->user_type === 'admin'){
            $input['user_type'] = 'guest'; 
        }

        $client = Client::create($input);

        Goal::create([
            'client_id' => $client->id
        ]);

        return response()->json($trainer->clients);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $client = Client::find($id);
        return response()->json($client);
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
        $client = Client::find($id);

        $client->age = $request->age;
        $client->weight = $request->weight;
        $client->height = $request->height;
        $client->description = $request->desc;
        $client->city = $request->city;
        $client->phone_number = $request->phoneNumber;
        $client->save();

        return response()->json($client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $galleries = Gallery::where('client_id', $id)->get();
        
        foreach($galleries as $gallery){
            unlink(storage_path('app/public/Gallery/' . $gallery->front_image));
            unlink(storage_path('app/public/Gallery/' . $gallery->back_image));
            unlink(storage_path('app/public/Gallery/' . $gallery->side_image));
        }
        
        $galleries = Gallery::where('client_id', $id)->delete();
        $goal = Goal::where('client_id', $id)->delete();
        $client->delete();

        return response(['success'=> 'Success'], 200);
    }

}
