<?php

namespace App\Http\Controllers;

use App\Checklist;
use Exception;
use Illuminate\Http\Request;

class ChecklistController extends Controller
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
          $checklist = Checklist::create($request->all());
          return response()->json($checklist, 201);
        } catch (Exception $e) {
          return response()->json($e->getMessage(), 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function show(Checklist $checklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Checklist $checklist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checklist $checklist)
    {
      try {
        $checklist->update($request->all());
        return response()->json(['message' => 'Checklist item updated', 'item' => $checklist], 200);
      } catch (Exception $e) {
        return response()->json($e->getMessage(), 200);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checklist  $checklist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checklist $checklist)
    {
      try {
        $checklist->delete();
        return response()->json('item deleted', 201);
      } catch (Exception $e) {
        return response()->json($e->getMessage(), 200);
      }
    }
}
