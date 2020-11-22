<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Trainer; 


class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function update(Request $request, $id)
    {
        $trainer = Trainer::find($id);
        $trainer->age = $request->age;
        $trainer->height = $request->height;
        $trainer->weight = $request->weight;
        $trainer->description = $request->description;
        $trainer->city = $request->city;
        $trainer->phone_number = $request->phoneNumber;
        $trainer->main_sport = $request->mainSport;
        $trainer->instagram = $request->instagram;
        $trainer->facebook = $request->facebook;

        if($request->profileImage != null){
            if($trainer->photo_url != null){
                unlink(storage_path("app/public/TrainerProfileImage/" . $trainer->photo_url));
            }
            $imageUrl = $request->profileImage;
            $image = str_replace('data:image/png;base64,', '', $imageUrl);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(15).'.'.'png';
            Storage::disk('local')->put("public/TrainerProfileImage/" . $imageName, base64_decode($imageUrl));
            $trainer->photo_url = $imageName;
            $trainer['photo_url'] = storage_path('app/public/TrainerProfileImage/' . $trainer->photo_url);
        }

        $trainer->save();
        return response()->json($trainer);
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
}
