<?php

namespace App\Http\Controllers;

use App\Company;
use App\Form;
use App\RDCredit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return response()->json(
        Company::with(['research_and_development', 'forms', 'alerts', 'attorneystatements', 'checklists', 'keydates', 'qualifyingpercentage'])
        ->get(), 200);
    }

    public function list(){
      return response()->json(
        Company::select('id','name','ein')->get(), 200);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listAllForms(Request $request){
      return response()->json(
        Company::select('id','name','ein')->where('id', $request->companyId)->with(['_941_2021','scheduleB', '_8974'])
        ->get(), 200);
    }

  public function consolidatedRD()
  {
    return response()->json(
      Company::select('name', 'id')->with(['research_and_development_consolidated'])->get(), 200);
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
      /* *
        companyName
        taxID
        businessStartDate
        yearEndDate
        firstIncomeYear
        finalPayrollDate
        companyType
        email
        phone
        officer
       * */
      try {
        // Date format is Y-m-d
        $c = Company::create([
          'name' => $request->companyName,
          'ein' => $request->taxID,
          'business_start_date' => Carbon::parse(str_replace('-','/',$request->businessStartDate))->toDateString(),
          'business_first_year_end_date' => Carbon::parse(str_replace('-','/',$request->yearEndDate))->toDateString(),
          'first_income_year' => Carbon::parse(str_replace('-','/',$request->firstIncomeYear))->toDateString(),
          'final_date_payroll_claim' => $this->claimCalculation($request),
          'company_type' => $request->companyType,
          'email' => $request->email,
          'phone' => $request->phone,
          'officer' => $request->officer,
          'address' => $request->address,
        ]);

        $c->save();

        /* Add empty keys */
        $c->research_and_development = [];
        $c->forms = [];

        return response()->json(['status' => 200, 'message' => 'Request success.', 'company' => $c]);
      } catch (Exception $e) {
        return response()->json(['status' => 400, 'message' => 'Request failed. No duplicate entries allowed.', 'error' => $e]);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param Company $company
   * @return \Illuminate\Http\Response
   */
    public function update(Request $request, Company $company)
    {
      try {
        // Update company here
        // Make sure to Carbon::parse dates as they will be required
        if ($request->has('business_start_date')) {
          $request->business_start_date = Carbon::parse(str_replace('-','/',$request->business_start_date))->toDateString();
        }

        if ($request->has('business_first_year_end_date')) {
          $request->business_first_year_end_date = Carbon::parse(str_replace('-','/',$request->business_first_year_end_date))->toDateString();
        }

        if ($request->has('final_date_payroll_claim')) {
          $request->final_date_payroll_claim = Carbon::parse(str_replace('-','/',$request->final_date_payroll_claim))->toDateString();
        }

        if ($request->has('first_income_year')) {
          // Update final claim payroll here
          $request->first_income_year = Carbon::parse(str_replace('-','/',$request->first_income_year))->toDateString();
          $company->final_date_payroll_claim = $this->claimCalculation($request);
        }

        if ($request->has('override_date')) {
          $request->override_date = Carbon::parse(str_replace('-','/',$request->override_date))->toDateString();
        }

        $company->update($request->all());
        return response()->json($company, 200);
      } catch (Exception $e) {
        return response()->json(['message' => $e->getMessage()], 404);
      }

    }

  /**
   * Create the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param Company $company
   * @return \Illuminate\Http\Response
   */
  public function newCredit(Request $request){
    try {
      $request->period = Carbon::parse(str_replace('-','/', $request->period))->toDateString();
      $request->date_return_filed = Carbon::parse(str_replace('-','/', $request->date_return_filed))->toDateString();
      $credit = RDCredit::create($request->all());
      $form = Form::create([
        'company_id' => $request->company_id,
        'quarter' => $request->quarter,
        'year' => $request->year,
        'form_type' => $request->return_type,
        'period' => $request->period
      ]);
      return response()->json([$credit, $form], 200);
    } catch (Exception $e) {
      return response()->json(['message' => $e->getMessage()], 200);
    }
  }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
      try {
        $company->delete();
        return response()->json(['message' => 'company deleted'], 201);
      } catch (Exception $e) {
        return response()->json(['message' => $e->getMessage()], 404);
      }
    }

      /****/
  /**
   * @param Request $request
   * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
   */
//    public function claimCalculation($date, $endDate)
    public function claimCalculation(Request $request)
    {
      /* claim-calculation */
      try {

        /*
         * UPDATE 05-07-2020
         * Business Start/Year End/1st Income Dates are all provided
         * Year 0 is Start Date to Year End
         * 5 Year limit is calculated from Year End +1 month to Year End
         * */

        //$start_date = Carbon::parse(str_replace('-','/', $request->businessStartDate))->subDay()->format('m-d-Y');
        $start_date = Carbon::parse(str_replace('-','/', $request->businessStartDate));

//        $year_end_date = (Carbon::parse($date)->month !== Carbon::parse($endDate)->month) ? Carbon::parse($date)->endOfYear() : Carbon::parse($date)->endOfMonth();
        $year_end_date = Carbon::parse(str_replace('-','/', $request->yearEndDate));

        //        $first_income_year = (Carbon::parse($date)->month !== Carbon::parse($endDate)->month) ? Carbon::parse($date)->endOfYear()->addYear() : Carbon::parse($date)->endOfMonth();
        $first_income_year = Carbon::parse(str_replace('-','/',$request->firstIncomeYear));

        /* This is the Year 1 Starting point. We already have the year end in the variable year_end_date */
//        $year_one_start = (Carbon::parse($date)->month !== Carbon::parse($endDate)->month) ? Carbon::parse($date)->endOfYear()->addDay() : Carbon::parse($date)->endOfMonth()->addDay();
        $year_one_start = Carbon::parse(str_replace('-','/',$year_end_date))->addDay();

/*        return response()->json([
          'status' => 201,
          'message' => 'success',
          'start_date' => $start_date->toDateString(),
          'year_end_date' => (clone $year_end_date)->toDateString(),
          'first_income_year' => (clone $first_income_year)->toDateString(),
          'year_one' => (clone $year_one_start)->toDateString() . ' - ' . (clone $year_end_date)->addYear()->toDateString(),
          'year_two' => (clone $year_one_start)->addYears(1)->toDateString() . ' - ' . (clone $year_end_date)->addYears(2)->toDateString(),
          'year_three' => (clone $year_one_start)->addYears(2)->toDateString() . ' - ' . (clone $year_end_date)->addYears(3)->toDateString(),
          'year_four' => (clone $year_one_start)->addYears(3)->toDateString() . ' - ' . (clone $year_end_date)->addYears(4)->toDateString(),
          'year_five' => (clone $year_one_start)->addYears(4)->toDateString() . ' - ' . (clone $year_end_date)->addYears(5)->toDateString(),
          'last_year_payroll_claimable' => (clone $year_end_date)->addYears(5)->toDateString()
        ]);*/

        if ($request->has('first_income_year')) {
          $incYearNew = Carbon::parse(str_replace('-','/',$request->first_income_year));
          return (clone $incYearNew)->addYears(4)->toDateString();
        } else
          return (clone $year_end_date)->addYears(5)->toDateString();
      } catch (Exception $e) {
        return response()->json([
          'status' => 400,
          'message' => 'Invalid data!',
          'data' => $e->getMessage()
        ]);
      }

    }

    public function sorted (Request $request, Company $company) {
//        $request->sorted = json_decode($request->sorted);
        $company->sorted = json_decode($request->sorted);
        $company->save();
        return response()->json([$request->sorted, $company->name, $company->id]);
    }


}