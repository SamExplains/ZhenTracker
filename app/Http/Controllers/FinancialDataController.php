<?php

namespace App\Http\Controllers;

use App\FinancialData;
use Exception;
use Illuminate\Http\Request;

class FinancialDataController extends Controller
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
          $_fd = FinancialData::create([
                                        'company_id' => $request->company_id,
                                        'qq_id' => $request->qq_id,
                                        'qq_year' => $request->qq_year,
                                        'selected_type' => $request->selected_type,
                                        'name' => $request->name,
                                        'title' => ($request->has('title') ? $request->title : null),
                                        'amount' => ($request->has('amount') ? $request->amount : null)
                                      ]);
          return response()->json($_fd, 201);
        } catch (Exception $e) {
          return response()->json($e->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FinancialData  $financialData
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialData $financialData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FinancialData  $financialData
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialData $financialData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FinancialData  $financialData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialData $fd)
    {
        try {
          $fd->update($request->all());
          $fd->save();
          return response()->json($fd, 201);
        } catch (Exception $e) {
          return response()->json($e->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FinancialData  $financialData
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialData $fd)
    {
      try {
        $fd->delete();
        return response()->json('delete success', 201);
      } catch (\Throwable $th) {
        return response()->json('no record found', 404);
      }
    }
}
