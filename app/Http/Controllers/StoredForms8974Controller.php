<?php

namespace App\Http\Controllers;

use App\StoredForms8974;
use Illuminate\Http\Request;

class StoredForms8974Controller extends Controller
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
        $record_exists = StoredForms8974::where('company_id', '=', $request->company_id)->where('quarter', '=', $request->quarter)->get();
        $record = null;
        // new record flag | If true use success notification if false use update notification
        $new_record = false;
        // No records exist
        if (count($record_exists) < 1) {
        $new_record = true;
        $record= StoredForms8974::create([
          'company_id'=> $request->company_id,
          'form_name' => $request->form_name,
          'form_year' => $request->form_year,
          'eid' => $request->eid,
          'name' => $request->name,
          'credit_checkbox' => $request->credit_checkbox,
          'quarter' => $request->quarter,
          'part_one' => $request->part_one,
          'part_one_total' => $request->part_one_total,
          'seven' => $request->seven,
          'eight' => $request->eight,
          'nine' => $request->nine,
          'ten' => $request->ten,
          'eleven' => $request->eleven,
          'eleven_checkbox' => $request->eleven_checkbox,
          'twelve' => $request->twelve]);
          $record->save();
        } else {
          // PATCH the record
          $new_record = false;
          $found = StoredForms8974::where('company_id', '=', $request->company_id)->where('quarter', '=', $request->quarter)->first();
          $found->update([
          'company_id'=> $request->company_id,
          'form_name' => $request->form_name,
          'form_year' => $request->form_year,
          'eid' => $request->eid,
          'name' => $request->name,
          'credit_checkbox' => $request->credit_checkbox,
          'quarter' => $request->quarter,
          'part_one' => $request->part_one,
          'part_one_total' => $request->part_one_total,
          'seven' => $request->seven,
          'eight' => $request->eight,
          'nine' => $request->nine,
          'ten' => $request->ten,
          'eleven' => $request->eleven,
          'eleven_checkbox' => $request->eleven_checkbox,
          'twelve' => $request->twelve]);
        }

        return response()->json(['new_record_created' => $new_record], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoredForms8974  $storedForms8974
     * @return \Illuminate\Http\Response
     */
    public function show(StoredForms8974 $storedForms8974)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoredForms8974  $storedForms8974
     * @return \Illuminate\Http\Response
     */
    public function edit(StoredForms8974 $storedForms8974)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoredForms8974  $storedForms8974
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoredForms8974 $storedForms8974)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoredForms8974  $storedForms8974
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoredForms8974 $storedForms8974)
    {
        //
    }
}