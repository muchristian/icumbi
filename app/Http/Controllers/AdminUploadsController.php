<?php

namespace App\Http\Controllers;

use App\Uploads;
use App\House;
use Illuminate\Http\Request;

class AdminUploadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($house)
    {
        $data = [
          "pics" =>Uploads::where('house_id', $house)->get(),
          "house_id" => $house
        ]; 
        return view('admin.uploads.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($house_id)
    {
        //
        return view('admin.uploads.create', compact('house_id'));
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
        $destinationPath = public_path('/images/HouseUploads');
        
        foreach($request->photos as $photo) {
            $filename = time() . $photo->getClientOriginalName() . '.'. $photo->getClientOriginalExtension();
            //die($filename);
            $photo->move($destinationPath, $filename);
            Uploads::create([
                "house_id" => $request->input('house_id'),
                "name" => "image",
                "title" => "image",
                "source" => $filename
            ]);
        }
        return redirect()->route('admin.uploads.index', $request->input('house_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function show(Uploads $uploads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function edit(Uploads $uploads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uploads $uploads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Uploads  $uploads
     * @return \Illuminate\Http\Response
     */
    public function destroy($uploads)
    {
        //
        $upload = Uploads::find($uploads);
        if ($upload) {
            $src = $upload->source;
            $house_id = $upload->house_id;
            if ($upload->delete()) {
                @unlink(public_path('/images/HouseUploads/' . $src));
                return redirect()->route('admin.uploads.index', $house_id);
            } else {
                return back()->withInput();
            }
        }
    }
}
