<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//Route::get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('company')->group(function () {

    Route::get('/', 'CompanyController@index');
    Route::post('/', 'CompanyController@store');
    Route::delete('/{company}', 'CompanyController@destroy');

    // Consolidated Company Info
    Route::get('/consolidated', 'RDCreditsController@index');
    Route::get('/consolidated-rd', 'CompanyController@consolidatedRD');

    // Claim Calculation
    //  Route::post('/claim-calculation/{date}/{endDate}', 'CompanyController@claimCalculation');
    Route::post('/claim-calculation', 'CompanyController@claimCalculation');

    // Alerts
    Route::get('/events', 'AlertController@index');
    Route::post('/events', 'AlertController@store');
    Route::delete('/events/{alert}', 'AlertController@destroy');

    Route::put('/update/{company}', 'CompanyController@update');
    Route::post('/new-credit', 'CompanyController@newCredit');

    //Delete credit
    Route::delete('/delete-credit/{credit}', 'RDCreditsController@destroy');

    // Update Credit Recieved
    Route::put('/update-rdc/{credit}', 'RDCreditsController@update');

    Route::post('/form-upload/{form}', 'FormController@store');
    Route::post('/form-upload-additional/{form}', 'FormController@storeAdditional');
    Route::put('/form-update-additional/{form}', 'FormController@updateAdditional');
    Route::post('/b64-upload', 'FormController@decodeBase64ImageAndStore');

    // Attorney and Work Forms
    Route::post('/attorney-work/{company}', 'AttorneyandWorkController@store');
    Route::delete('/attorney-work/{attorneyandWork}', 'AttorneyandWorkController@destroy');

    // Checklist PUT / Update Checklist item
    Route::put('/checklist/{checklist}', 'ChecklistController@update');
    // Checklist POST Checklist item
    Route::post('/checklist', 'ChecklistController@store');
    // Checklist DELETE Checklist item
    Route::delete('/checklist/{checklist}', 'ChecklistController@destroy');

    // Delete
    Route::post('/form/{form}', 'FormController@destroyFile');

    // Store Key Due Date
    Route::post('/kdd', 'KeyDueDatesController@store');
    Route::delete('/kdd/{keyDueDate}', 'KeyDueDatesController@destroy');

    // Association
    Route::get('/association', 'HomeController@usersWithAssociation');
    Route::post('/association', 'AssociationController@store');

    //Update user password
    Route::post('/user/{user}', 'UserController@update');

    // Analyzer API endpoints
    Route::post('/analyzer/qq/{year}', 'QualifyingQuestionsYearsController@store');
    Route::get('/analyzer/qq/{companyId}', 'QualifyingQuestionsYearsController@index');
    Route::delete('/analyzer/qq/{companyId}', 'QualifyingQuestionsYearsController@destroy');

    // Financial Data
    Route::post('/analyzer/fd/', 'FinancialDataController@store');
    Route::put('/analyzer/fd/{fd}', 'FinancialDataController@update');
    Route::delete('/analyzer/fd/{fd}', 'FinancialDataController@destroy');

    // Qualifying Percentage
    Route::post('/analyzer/qp/', 'QualifyingPercentageController@store');
    Route::put('/analyzer/qp/{qualifyingPercentage}', 'QualifyingPercentageController@update');
    Route::get('/analyzer/qp/{id}', 'QualifyingPercentageController@index');

    // Project Documentation
    Route::post('/analyzer/pd', 'QualifyingPercentageController@storeFile');

    //Update Company Sorted Field
    Route::put('/sorted/{company}', 'CompanyController@sorted');

    /**
     * StoredForms API endpoints
     * /list – all companys stored
     * /company_name – all forms for that company
     * /company_name/stored_id – get the specified details for said company stored form.
     * /new
     *
     */
    // Company now returns all stored forms as eager loaded
    Route::get("forms", "CompanyController@indexFormsOnly");

    // Store new resource in DB
    Route::post('/stored/new', 'StoredFormsController@store');

    //Get a List of Companies Names, ID, EID
    Route::get('/list', 'CompanyController@list');
    //Get a List of all Companies Names, ID, EID, and lazy loaded Schedule B and 941_2021
    Route::get('/list/{companyId}', 'CompanyController@listAllForms');

    // GET all forms for a Given Company ( Only 941 2021)
    Route::get('/stored/{companyId}', 'StoredFormsController@index');

    // GET a specific form stored for a Company (Only 941 2021)
    Route::get('/stored/get/{id}', 'StoredFormsController@returnStoredFormRecord');

    //Store new schedule b record
    Route::post('/stored/new/b', "StoredFormsScheduleBController@store");

    Route::post('/stored/new/8974', "StoredForms8974Controller@store");
});

Route::prefix('partybemine')->group(function () {
    Route::post('/signup', 'StandardSignupController@store');
    Route::post('/quicklogin', 'StandardSignupController@quickLogin');
    Route::post('/login', 'StandardSignupController@login');
    // GET check if a sub account with the matching sub is saved
    Route::post('/google', 'StandardSignupController@checkIfGoogleAccountIsStored');
    Route::post('/create', 'EventController@create');
    Route::get('/events/{filter}', 'EventController@index');
    // GET events created by the user
    Route::get('/events/creator/{uid}', 'EventController@getCreatorEvents');
    Route::get('/events/search/{query}', 'EventController@search');
    // PATCH event registered field
    Route::patch('/events/{eid}', 'EventController@updateRegistered');
    // PATCH event checklist
    Route::patch('/checklist', 'EventController@updateChtecklist');

    // Find private event by shareable key and regster a user
    Route::post("/events/private/{eventId}", "EventController@addPrivateEvent");

    Route::delete('/registration', 'RegistrationController@destroy');
    // INSERT registration record
    Route::post('/registration', 'RegistrationController@store');
    // GET registered events list
    Route::get('/registration/{uid}', 'RegistrationController@index');
    // GET check if user is registered for event
    Route::get('/registration/user/{uid}/{eid}', 'RegistrationController@checkIfUserIsRegistered');
    // PATCH registration record
    Route::patch('/registration/{registration}', 'RegistrationController@update');

    // Check a user in
    Route::patch("/registration/user/checkin", "RegistrationController@checkUserIn");
    // Get Registration Check-In count
    Route::get('/registration/checkin/{eid}', 'RegistrationController@returnCheckinAmount');
    // PATCH user profile details
    Route::patch('/user/details', 'StandardSignupController@updateProfileDetails');
});