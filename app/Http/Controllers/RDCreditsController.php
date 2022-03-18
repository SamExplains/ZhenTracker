<?php

namespace App\Http\Controllers;

use App\Form;
use App\RDCredit;
use Exception;
use Illuminate\Http\Request;

class RDCreditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json([
       'total' => RDCredit::all()->sum('credit_amount'),
       'filed' => RDCredit::all()->sum('credit_claimed'),
       'received' => RDCredit::all()->sum('credit_received')
      ]);
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
     * @param  \App\RDCredit  $rDCredits
     * @return \Illuminate\Http\Response
     */
    public function show(RDCredit $rDCredits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RDCredit  $rDCredits
     * @return \Illuminate\Http\Response
     */
    public function edit(RDCredit $rDCredits)
    {
        //
    }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param RDCredit $credit
   * @return void
   */
    public function update(Request $request, RDCredit $credit)
    {
        try{
          $credit->update($request->all());
          return response()->json($credit, 201);
        } catch (Exception $e) {
          return response()->json($e->getMessage());
        }
    }

      /****/
        public function delete(RDCredit $credit)
        {
          return response()->json($credit);
        }

  /**
   * Remove the specified resource from storage.
  *
   * @param RDCredit $credit
   * @return \Illuminate\Http\Response
   * @throws \Exception
   */
    public function destroy(RDCredit $credit)
    {
      $credit->delete();
      $creditFormExists = Form::find($credit->id);
      $creditFormExists->delete();

      return response()->json($credit, 201);
    }
}