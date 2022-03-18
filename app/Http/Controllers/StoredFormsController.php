<?php

namespace App\Http\Controllers;

use App\StoredForms;
use Illuminate\Http\Request;

class StoredFormsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = StoredForms::where('company_id', $request->companyId)->get();
        return response()->json($records, 201);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function returnStoredFormRecord(Request $request)
    {
        // $r = StoredForms::find($request->id);
        $r = StoredForms::find($request->id);

        if ($r) {
            $r->five_a = json_decode($r->five_a);
            $r->five_aa = json_decode($r->five_aa);
            $r->five_aaa = json_decode($r->five_aaa);
            $r->five_b = json_decode($r->five_b);
            $r->five_c = json_decode($r->five_c);
            $r->five_d = json_decode($r->five_d);
            return response()->json($r, 201);
        } else {
            return response()->json(['message' => 'no data found.'], 201);
        }

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
        $record_exists = StoredForms::where('company_id', '=', $request->company_id)->where('quarter', '=', $request->quarter)->get();
        $record = null;
        // new record flag | If true use success notification if false use update notification
        $new_record = false;
        // No records exist
        if (count($record_exists) < 1) {
            // Check Records if a Record with the SELECTED Quarter Already Exists
            // If it does make sure to PATCH ELSE CREATE
            $new_record = true;
            $record = StoredForms::create([
                'company_id' => $request->company_id,
                'form_name' => $request->form_name,
                'form_year' => $request->form_year,
                'eid' => $request->eid,
                'name' => $request->name,
                'trade_name' => $request->trade_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'foreign_country_name' => $request->foreign_country_name,
                'foreign_country_providence' => $request->foreign_country_providence,
                'foreign_country_postal_code' => $request->foreign_country_postal_code,
                'quarter' => $request->quarter,
                'one' => $request->one,
                'two' => $request->two,
                'three' => $request->three,
                'four' => $request->four,
                'five_a' => $request->five_a,
                'five_aa' => $request->five_aa,
                'five_aaa' => $request->five_aaa,
                'five_b' => $request->five_b,
                'five_c' => $request->five_c,
                'five_d' => $request->five_d,
                'five_e' => $request->five_e,
                'five_f' => $request->five_f,
                'six' => $request->six,
                'seven' => $request->seven,
                'eight' => $request->eight,
                'nine' => $request->nine,
                'ten' => $request->ten,
                'eleven_a' => $request->eleven_a,
                'eleven_b' => $request->eleven_b,
                'eleven_c' => $request->eleven_c,
                'eleven_d' => $request->eleven_d,
                'eleven_g' => $request->eleven_g,
                'twelve' => $request->twelve,
                'thirteen' => $request->thirteen,
                'thirteen_b' => $request->thirteen_b,
                'thirteen_c' => $request->thirteen_c,
                'thirteen_d' => $request->thirteen_d,
                'thirteen_e' => $request->thirteen_e,
                'thirteen_f' => $request->thirteen_f,
                'thirteen_g' => $request->thirteen_g,
                'thirteen_h' => $request->thirteen_h,
                'thirteen_i' => $request->thirteen_i,
                'fourteen' => $request->fourteen,
                'fifteen' => $request->fifteen,
                'fifteen_checkbox' => $request->fifteen_checkbox,
                'sixteen_a' => $request->sixteen_a,
                'sixteen_b' => $request->sixteen_b,
                'sixteen_b_month_1' => $request->sixteen_b_month_1,
                'sixteen_b_month_2' => $request->sixteen_b_month_2,
                'sixteen_b_month_3' => $request->sixteen_b_month_3,
                'sixteen_b_sum' => $request->sixteen_b_sum,
                'sixteen_c' => $request->sixteen_c,
            ]);
            $record->save();
        } else {
            // PATCH the record
            $new_record = false;
            $found = StoredForms::where('company_id', '=', $request->company_id)->where('quarter', '=', $request->quarter)->first();
            $found->update([
                'company_id' => $request->company_id,
                'form_name' => $request->form_name,
                'form_year' => $request->form_year,
                'eid' => $request->eid,
                'name' => $request->name,
                'trade_name' => $request->trade_name,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'foreign_country_name' => $request->foreign_country_name,
                'foreign_country_providence' => $request->foreign_country_providence,
                'foreign_country_postal_code' => $request->foreign_country_postal_code,
                'quarter' => $request->quarter,
                'one' => $request->one,
                'two' => $request->two,
                'three' => $request->three,
                'four' => $request->four,
                'five_a' => $request->five_a,
                'five_aa' => $request->five_aa,
                'five_aaa' => $request->five_aaa,
                'five_b' => $request->five_b,
                'five_c' => $request->five_c,
                'five_d' => $request->five_d,
                'five_e' => $request->five_e,
                'five_f' => $request->five_f,
                'six' => $request->six,
                'seven' => $request->seven,
                'eight' => $request->eight,
                'nine' => $request->nine,
                'ten' => $request->ten,
                'eleven_a' => $request->eleven_a,
                'eleven_b' => $request->eleven_b,
                'eleven_c' => $request->eleven_c,
                'eleven_d' => $request->eleven_d,
                'eleven_g' => $request->eleven_g,
                'twelve' => $request->twelve,
                'thirteen' => $request->thirteen,
                'thirteen_b' => $request->thirteen_b,
                'thirteen_c' => $request->thirteen_c,
                'thirteen_d' => $request->thirteen_d,
                'thirteen_e' => $request->thirteen_e,
                'thirteen_f' => $request->thirteen_f,
                'thirteen_g' => $request->thirteen_g,
                'thirteen_h' => $request->thirteen_h,
                'thirteen_i' => $request->thirteen_i,
                'fourteen' => $request->fourteen,
                'fifteen' => $request->fifteen,
                'fifteen_checkbox' => $request->fifteen_checkbox,
                'sixteen_a' => $request->sixteen_a,
                'sixteen_b' => $request->sixteen_b,
                'sixteen_b_month_1' => $request->sixteen_b_month_1,
                'sixteen_b_month_2' => $request->sixteen_b_month_2,
                'sixteen_b_month_3' => $request->sixteen_b_month_3,
                'sixteen_b_sum' => $request->sixteen_b_sum,
                'sixteen_c' => $request->sixteen_c,
            ]);
        }
        return response()->json(['new_record_created' => $new_record], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StoredForms  $storedForms
     * @return \Illuminate\Http\Response
     */
    public function show(StoredForms $storedForms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StoredForms  $storedForms
     * @return \Illuminate\Http\Response
     */
    public function edit(StoredForms $storedForms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StoredForms  $storedForms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoredForms $storedForms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StoredForms  $storedForms
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoredForms $storedForms)
    {
        //
    }
}