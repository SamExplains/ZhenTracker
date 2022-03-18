<?php

namespace App\Http\Controllers;

use App\StoredFormsScheduleB;
use Illuminate\Http\Request;

class StoredFormsScheduleBController extends Controller
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

        // If records exist return > 0
        $record_exists = StoredFormsScheduleB::where('company_id', '=', $request->company_id)->where('quarter', '=', $request->quarter)->get();
        $record = null;
        // new record flag | If true use success notification if false use update notification
        $new_record = false;
        // No records exist
        if (count($record_exists) < 1) {

        $new_record = true;
        $record= StoredFormsScheduleB::create([
          'company_id'=> $request->company_id,
          'form_name' => $request->form_name,
          'form_year' => $request->form_year,
          'eid' => $request->eid,
          'name' => $request->name,
          'quarter' => $request->quarter,
          'month_one' => $request->month_one,
          'month_one_tax_liability' => $request->month_one_tax_liability,
          'month_two' => $request->month_two,
          'month_two_tax_liability' => $request->month_two_tax_liability,
          'month_three' => $request->month_three,
          'month_three_tax_liability' => $request->month_three_tax_liability,
          'total_liability' => $request->total_liability]);
          $record->save();
        } else {
          // PATCH the record
          $new_record = false;
          $found = StoredFormsScheduleB::where('company_id', '=', $request->company_id)->where('quarter', '=', $request->quarter)->first();
          $found->update([
            'company_id'=> $request->company_id,
            'form_name' => $request->form_name,
            'form_year' => $request->form_year,
            'eid' => $request->eid,
            'name' => $request->name,
            'quarter' => $request->quarter,
            'month_one' => $request->month_one,
            'month_one_tax_liability' => $request->month_one_tax_liability,
            'month_two' => $request->month_two,
            'month_two_tax_liability' => $request->month_two_tax_liability,
            'month_three' => $request->month_three,
            'month_three_tax_liability' => $request->month_three_tax_liability,
            'total_liability' => $request->total_liability]);
        }

        return response()->json(['new_record_created' => $new_record], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoredFormsScheduleB  $storedFormsScheduleB
     * @return \Illuminate\Http\Response
     */
    public function show(StoredFormsScheduleB $storedFormsScheduleB)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoredFormsScheduleB  $storedFormsScheduleB
     * @return \Illuminate\Http\Response
     */
    public function edit(StoredFormsScheduleB $storedFormsScheduleB)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoredFormsScheduleB  $storedFormsScheduleB
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoredFormsScheduleB $storedFormsScheduleB)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoredFormsScheduleB  $storedFormsScheduleB
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoredFormsScheduleB $storedFormsScheduleB)
    {
        //
    }
}