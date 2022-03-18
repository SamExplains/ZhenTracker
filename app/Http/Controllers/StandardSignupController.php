<?php

namespace App\Http\Controllers;

use App\StandardSignup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StandardSignupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Storage::disk('public')->put('example.txt', 'Contents');
        return response()->json('Hey');
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
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function show(StandardSignup $standardSignup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function edit(StandardSignup $standardSignup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StandardSignup $standardSignup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StandardSignup $standardSignup)
    {
        //
    }
}