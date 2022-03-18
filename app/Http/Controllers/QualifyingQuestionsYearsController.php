<?php

namespace App\Http\Controllers;

use App\QualifyingQuestionsYears;
use Exception;
use Illuminate\Http\Request;

class QualifyingQuestionsYearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($companyId)
    {
        // Get all records for the Selected Company
        $records = QualifyingQuestionsYears::where('companyId', $companyId)->with(['financial_data'])->get();
        return response()->json($records, 201);
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
    public function store(Request $request, String $year)
    {
      try {
        //code...
        $qqy = QualifyingQuestionsYears::create([
          'year' => $year,
          'companyId' => $request->companyId
        ]);
        return response()->json($qqy, 201);
      } catch (Exception $e) {
        //throw $th;
        return response()->json('failed storing new qualifying question year', 400);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QualifyingQuestionsYears  $qualifyingQuestionsYears
     * @return \Illuminate\Http\Response
     */
    public function show(QualifyingQuestionsYears $qualifyingQuestionsYears)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QualifyingQuestionsYears  $qualifyingQuestionsYears
     * @return \Illuminate\Http\Response
     */
    public function edit(QualifyingQuestionsYears $qualifyingQuestionsYears)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QualifyingQuestionsYears  $qualifyingQuestionsYears
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualifyingQuestionsYears $qualifyingQuestionsYears)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QualifyingQuestionsYears  $qualifyingQuestionsYears
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualifyingQuestionsYears $companyId)
    {
      try {
        $companyId->delete();
        return response()->json('success', 200);
      } catch (\Throwable $th) {
        return response()->json('Could not delete. Check logs', 200);
      }
    }
}
