<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
// import the Intervention Image Manager Class
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    private $s3BaseClientUL = "https://momsinla-storage.s3.us-west-1.amazonaws.com";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return DB::table('events')->orderBy('id')->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $event_key = Str::random(10);
        // Generate QR code to link to website event
        $qrcode_name = Str::random(60);
        $event_output_file = "/partybemine/event_qr_codes/" . $qrcode_name . '.png';
        $qr_code = QrCode::size(500)->format('png')->generate("http://tracker.technologycredit.io/api/partybemine/event/" . $event_key);

        // Save event qr image
        Storage::disk('s3')->put($event_output_file, $qr_code);

        // $decodedBase64 = $this->returnDecodedImageAttributes($request->image);

        // Save image for local viewing
        // Storage::disk('public')->put('example.txt', $request->image);
        // Return event object with image URLs
        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'first_image' => (strlen($request->first_image)) ? $this->returnDecodedImageAttributes($request->first_image) : null,
            'second_image' => (strlen($request->second_image)) ? $this->returnDecodedImageAttributes($request->second_image) : null,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'public_private' => $request->public_private,
            'on_off_line' => $request->on_off_line,
            'check_in' => $request->check_in,
            'capacity' => $request->capacity,
            'additional_items' => $request->additional_items,
            'url' => $request->url,
            'email' => $request->email,
            'phone' => $request->phone,
            'qrcode' => $this->s3BaseClientUL . $event_output_file,
            'creator_id' => $request->creator_id,
            'event_key' => $event_key,
        ]);

        return response()->json($event, 200);
    }

    /**
     * @param $img
     * @param $username
     * @return array
     */
    private function returnDecodedImageAttributes($img)
    {
        $image = $img;
        $imageName = 'image_' . Str::random(60) . '.png'; //generating unique file name;
        $decodedBase64 = base64_decode($image);
        // Store locally for the meantime
        $output = "/partybemine/event_images/" . $imageName;
        $img = Image::make($decodedBase64)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->stream('jpeg', 90);

        Storage::disk('s3')->put($output, $img);
        return $this->s3BaseClientUL . $output;
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
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}