<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;



class GalleryController extends Controller
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
        // return 12333;
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
    public function edit(Request $request)
    {
        return response($request->id);
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
        //
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
