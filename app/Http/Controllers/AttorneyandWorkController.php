<?php

namespace App\Http\Controllers;

use App\AttorneyandWork;
use App\Company;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttorneyandWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
   * @param \Illuminate\Http\Request $request
   * @param Company $company
   * @return \Illuminate\Http\Response
   */
    public function store(Request $request, Company $company)
    {
      try {

        $fileUrl = $this->uploadFileAndReturnFileUrl($request);
        $AWDocument = AttorneyandWork::create([
          'company_id' => $company->id,
          'file_one_url' => $fileUrl
        ]);

        $AWDocument->save();
        return response()->json(['AWDocument' => $AWDocument], 201);

      } catch (Exception $e) {
        return response()->json(['m' => $e->getMessage()], 404);
      }
    }

  private function uploadFileAndReturnFileUrl(Request $request)
  {
    $file = $request->file_upload_one;
    $fileExtension = $file->getClientOriginalExtension();
    $imageName = Carbon::now()->timestamp . $file->getClientOriginalName();
    Storage::disk('s3')->putFileAs('company_forms/power_attorney', $file, $imageName);
    $fileUrl = Storage::disk('s3')->url('company_forms/power_attorney') . '/' . $imageName;
    return $fileUrl;
  }

    /**
     * Display the specified resource.
     *
     * @param  \App\AttorneyandWork  $attorneyandWork
     * @return \Illuminate\Http\Response
     */
    public function show(AttorneyandWork $attorneyandWork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AttorneyandWork  $attorneyandWork
     * @return \Illuminate\Http\Response
     */
    public function edit(AttorneyandWork $attorneyandWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AttorneyandWork  $attorneyandWork
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttorneyandWork $attorneyandWork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AttorneyandWork  $attorneyandWork
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttorneyandWork $attorneyandWork)
    {
        // Delete file
        try {
          $aaw = AttorneyandWork::find($attorneyandWork);
          Storage::disk('s3')->delete('company_forms/power_attorney/' . mb_substr($aaw[0]->file_one_url, 81));
          $attorneyandWork->delete();
          return response()->json('form deleted', 201);
        } catch (Exception $e) {
          return response()->json(['error' => $e->getMessage(), 'aaw' => $aaw], 201);
        }
    }
}
