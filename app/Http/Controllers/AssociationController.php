<?php

namespace App\Http\Controllers;

use App\Association;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Return user Association
      return response()->json(Association::where('user_id', '=', Auth()->id())->get(), 200);
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
        $user = User::create([
          'uid' => uniqid(),
          'name' => $request->name,
          'email' => $request->email,
          'password' => ($request->has('password') ? bcrypt($request->password) : '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
          'photoURL' => 'some-url',
          'description' => 'A short bio',
          'registration_date' => time(),
          'points' => '0',
          'status' => 'User',
          'online' => false,
          'signup_procedure' => 'app',
          'disabled' => false,
          'email_verified_at' => time(),
        ]);

        $association = Association::create([
          'user_id' => $user->id,
          'company_id' => $request->company_id,
          'company_name' => $request->company
        ]);

        return response()->json(['uid' => $user->id, 'name' => $user->name, 'association' => $association], 201);
      } catch (Exception $e) {
        return response()->json($e->getMessage(), 400);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function show(Association $association)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function edit(Association $association)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Association $association)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function destroy(Association $association)
    {
        //
    }
}
