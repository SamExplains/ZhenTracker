<?php

namespace App\Http\Controllers;

use App\StandardSignup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StandardSignupController extends Controller
{
    private $s3BaseClientUL = "https: //momsinla-storage.s3.us-west-1.amazonaws.com/partybemine";

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Clean input before storing in database
        // Encrypt Password
        $user_uuid = Str::uuid()->toString();
        $email = $request->email;
        $zip = $request->zip;
        $name = $request->name;
        $password = Hash::make($request->password);
        $phone = $request->phone;
        $uuid = $user_uuid;
        $profile_image_src = "https://momsinla-storage.s3.us-west-1.amazonaws.com/partybemine/profile/default.png";
        $token = Str::random(60);
        $domain = 'http://tracker.technologycredit.io/api/partybemine/user/' . $user_uuid;
        $role = 'USER';

        // Returns TRUE is exists FALSE if available
        $exits = StandardSignup::where('email', '=', $email)->exists();

        // Create user
        if (!$exits) {
            // Misc
            // Do not add spaces to the card otherwise it wont read when generated
            $VCARD = "BEGIN:VCARD
N:$name;
TEL;TYPE=work,VOICE:$phone
EMAIL:$email
URL:$domain
UID:$uuid
ROLE:$role
KIND:Application
VERSION:3.0
END:VCARD";

            // QrCode::size(500)->format('png')->generate($VCARD, public_path('/storage/' . $uuid . '.png'));
            $qr_code = QrCode::size(500)->format('png')->generate($VCARD);
            $output_file = "/partybemine/user_qr_codes/" . $uuid . '.png';

            // Save file
            Storage::disk('s3')->put($output_file, $qr_code);

            $user = StandardSignup::create([
                'role' => $role,
                'email' => $email,
                'zip' => $zip,
                'name' => $name,
                'password' => $password,
                'uuid' => $uuid,
                'qrcode_src' => $this->s3BaseClientUL . $output_file,
                'profile_image_src' => $profile_image_src,
                'token' => $token,
            ]);

            return response()->json($user, 201);

        } else {
            return response()->json('Email is taken.', 200);
        }

    }

    public function quickLogin(Request $request)
    {
        // Search user bby ID
        // Chheck if email, password and token match
        // IF Yes, Login ELSE send error
        // Check if the record exists
        $record = StandardSignup::select('id')->where('id', $request->id)->exists();
        if ($record) {
            // $user = StandardSignup::find(48)->makeVisible(['password']);
            $user = StandardSignup::find($request->id);
            $flag = (strtolower($request->email) === strtolower($user->email) && $request->token === $user->token) ? true : false;
            if ($flag) {
                return response()->json($user, 200);
            }
            return response()->json('Details do not match', 400);
        }
        return response()->json('No record found!', 400);
    }

    public function login(Request $request)
    {
        // Search user bby ID
        // Chheck if email, password and token match
        // IF Yes, Login ELSE send error
        // Check if the record exists
        $record = StandardSignup::select('email')->where('email', '=', $request->email)->exists();
        if ($record) {
            $user = StandardSignup::where('email', '=', $request->email)->get()->first()->makeVisible(['password']);
            $flag = (strtolower($request->email) === strtolower($user->email) && Hash::check($request->password, $user->password)) ? true : false;
            if ($flag) {
                return response()->json($user, 200);
            }
            return response()->json('Details do not match', 400);
        }
        return response()->json('No record found!', 400);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function show(StandardSignup $standardSignup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function edit(StandardSignup $standardSignup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StandardSignup $standardSignup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StandardSignup  $standardSignup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StandardSignup $standardSignup)
    {
        //
    }
}