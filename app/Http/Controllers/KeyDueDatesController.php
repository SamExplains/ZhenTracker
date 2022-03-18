<?php

namespace App\Http\Controllers;

use App\KeyDueDates;
use Exception;
use Illuminate\Http\Request;

class KeyDueDatesController extends Controller
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
      try {
        $newKDD = KeyDueDates::create($request->all());
        return response()->json($newKDD, 201);
      } catch (Exception $e) {
        return response()->json($e, 400);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KeyDueDates  $keyDueDates
     * @return \Illuminate\Http\Response
     */
    public function show(KeyDueDates $keyDueDates)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\KeyDueDates  $keyDueDates
     * @return \Illuminate\Http\Response
     */
    public function edit(KeyDueDates $keyDueDates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\KeyDueDates  $keyDueDates
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KeyDueDates $keyDueDates)
    {
        //
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param KeyDueDates $keyDueDate
   * @return void
   */
    public function destroy(KeyDueDates $keyDueDate)
    {
        try {
          $keyDueDate->delete();
        } catch (Exception $e) {
          return response()->json($e, 404);
        }
    }
}
