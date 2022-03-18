<?php

namespace App\Http\Controllers;

use App\QualifyingPercentage;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QualifyingPercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(String $id)
    {
      try {
        return response()->json(QualifyingPercentage::where('qq_id', '=', $id)->get(), 200);
      } catch (Exception $e) {
        return response()->json('Coult not find allocations record', 400);
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
        try {
          $qpRecord = QualifyingPercentage::create($request->all());
          return response()->json($qpRecord, 201);
        } catch (Exception $e) {
          return response()->json($e->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QualifyingPercentage  $qualifyingPercentage
     * @return \Illuminate\Http\Response
     */
    public function show(QualifyingPercentage $qualifyingPercentage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QualifyingPercentage  $qualifyingPercentage
     * @return \Illuminate\Http\Response
     */
    public function edit(QualifyingPercentage $qualifyingPercentage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QualifyingPercentage  $qualifyingPercentage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QualifyingPercentage $qualifyingPercentage)
    {
      try {
        $updatedRecord = $qualifyingPercentage->update($request->all());
        return response()->json($updatedRecord, 201);
      } catch (Exception $e) {
        return response()->json($e->getMessage(), 404);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QualifyingPercentage  $qualifyingPercentage
     * @return \Illuminate\Http\Response
     */
    public function destroy(QualifyingPercentage $qualifyingPercentage)
    {
        //
    }

    public function storeFile(Request $request){
      try {
        $fileUrl = $this->uploadFileAndReturnFileUrl($request);
        $fileNumber = $this->returnFileUploadNumber($request);
        return response()->json(['number' => $fileNumber, 'link' => $fileUrl], 200);
      } catch (Exception $e) {
        return response()->json($e->getMessage());
      }

    }

    private function returnFileUploadNumber(Request $request) {

      if($request->file_upload_one) {
        return 1;
      }

      if($request->file_upload_two) {
        return 2;
      }

      if($request->file_upload_three) {
        return 3;
      }

      if($request->file_upload_four) {
        return 4;
      }

      if($request->file_upload_five) {
        return 5;
      }

      if($request->file_upload_six) {
        return 6;
      }

      if($request->file_upload_seven) {
        return 7;
      }

    }

    private function uploadFileAndReturnFileUrl(Request $request)
    {
      $n = $this->returnFileUploadNumber($request);
      $file = -1;

      if ($n === 1) {
        $file = $request->file_upload_one;
      }

      if ($n === 2) {
        $file = $request->file_upload_two;
      }

      if ($n === 3) {
        $file = $request->file_upload_three;
      }

      if ($n === 4) {
        $file = $request->file_upload_four;
      }

      if ($n === 5) {
        $file = $request->file_upload_five;
      }

      if ($n === 6) {
        $file = $request->file_upload_six;
      }

      if ($n === 7) {
        $file = $request->file_upload_seven;
      }

      $fileExtension = $file->getClientOriginalExtension();
      $imageName = Carbon::now()->timestamp . $file->getClientOriginalName();
      Storage::disk('s3')->putFileAs('company_forms/project_docs', $file, $imageName);
      $fileUrl = Storage::disk('s3')->url('company_forms/project_docs') . '/' . $imageName;
      return $fileUrl;
    }

}
