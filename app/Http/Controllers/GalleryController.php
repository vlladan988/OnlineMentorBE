<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;
use App\Models\Client;
use \stdClass;



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
        Gallery::create([
            'client_id' => $client->id,
            'front_image' => $imageDbName[0],
            'back_image' => $imageDbName[1],
            'side_image' => $imageDbName[2],
            'weight' => $client->weight,
        ]);

        return $this->responseWithImageData($client);
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
        return $this->responseWithImageData($client);
    }

    public function responseWithImageData($client){
        $galleryListImage = [];
        $galleries = $client->galleries;

        foreach($galleries as $gallery){
            $arrayOfPhotos = [
                storage_path('app/public/Gallery/' . $gallery->front_image),
                storage_path('app/public/Gallery/' . $gallery->back_image), 
                storage_path('app/public/Gallery/' . $gallery->side_image)
            ];

            $galleryObj = new stdClass();
            $galleryObj->id = $gallery->id;
            $galleryObj->date = $gallery->created_at;
            $galleryObj->city = $client->city;
            $galleryObj->weight = $gallery->weight;
            $galleryObj->name = $client->full_name;
            $galleryObj->photos = $arrayOfPhotos;
            array_push($galleryListImage,$galleryObj);
        }

        return response()->json($galleryListImage);
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
    public function destroy(Request $request, $id)
    {
        $gallery = Gallery::find($id);
        $client = Client::find($gallery->client_id);
        unlink(storage_path('app/public/Gallery/' . $gallery->front_image));
        unlink(storage_path('app/public/Gallery/' . $gallery->back_image));
        unlink(storage_path('app/public/Gallery/' . $gallery->side_image));
        $gallery->delete();

        return $this->responseWithImageData($client);
    }
}
