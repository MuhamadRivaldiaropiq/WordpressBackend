<?php

namespace App\Http\Controllers;

use App\Models\Wordpress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WordpressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Wordpress::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $wp = new Wordpress();
        $wp->username = $request->username;
        $wp->password = Hash::make($request->password);
        $wp->domain = $request->domain;
        $wp->token = $request->token;
        $wp->save();
        return response()->json($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wordpress $wordpress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wordpress $wordpress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $wp = Wordpress::find($id);
        $wp->token = $request->token;
        $wp->save();
        return response()->json($wp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wordpress $wordpress)
    {
        $wordpress->delete();
        return response()->json($wordpress);
    }
    public function getDataById($id){
        $wp = Wordpress::find($id);
        return response()->json($wp);
    }
    // public function updateToken(Request $request, $id) {
    //     $wp = Wordpress::find($id);
    //     // dd($id);
    //     $wp->token = $request->tokens;
    //     $wp->save();
    //     return response()->json($wp);
    // }
}
