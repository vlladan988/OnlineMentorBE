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
        // $userType = $request->userType;
        $trainer = auth('api-trainer')->user();
        // if($userType === 'admin'){
        //     return response()->json($trainer->guestClients);
        // } else if($userType === 'trainer'){
        //     return response()->json($trainer->clients);
        // }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        $client = Client::find($request->id);

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
        //
    }

    public function measurementsCreate(Request $request)
    {
        return 123;
    }

    public function storeGallery(Request $request)
    {
        

        $images = $request->photos; 
        $imageDbName = [];
        foreach($images as $imageItem) {
            $image = str_replace('data:image/png;base64,', '', $imageItem);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(15).'.'.'png';
            array_push($imageDbName, $imageName);
            Storage::disk('local')->put("public/Gallery/" . $imageName, base64_decode($imageItem));
        }

        $client = auth('api-client')->user();
        $gallery = Gallery::create([
            'client_id' => $client->id,
            'front_image' => $imageDbName[0],
            'back_image' => $imageDbName[1],
            'side_image' => $imageDbName[2],
        ]);

        return response()->json($gallery);

    }
}
