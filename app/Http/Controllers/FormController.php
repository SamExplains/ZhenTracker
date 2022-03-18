<?php

namespace App\Http\Controllers;

use App\Form;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param Form $form
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Form $form)
    {
        /*
         * ✅ Check the file extension type
         * ✅ Create a unique name for file
         * ✅ Send back filename and URL
         * ✅ Send correct status codes
         */
//      $fileExtension = $request->file_upload_one->getClientOriginalExtension();
        //      $imageName = Carbon::now()->timestamp . $request->file_upload_one->getClientOriginalName();

        /*
         * Check only for second files
         * */

        /*      if ($fileExtension !== 'pdf')
        return response()->json(['status' => 400, 'message' => 'error. Invalid file type.', 'extension' => $fileExtension, 'data' => $request->all()]);

        if (Storage::disk('s3')->putFileAs('company_forms', $request->file_upload_one, $imageName)) {
        $fileUrl = Storage::disk('s3')->url('company_forms') . '/' . $imageName;
        return response()->json($form, 200);
        } else
        return response()->json(['status' => 500, 'message' => 'error. Failed to store file.', 'data' => $request->all()]);*/

        $fileUrl = $this->uploadFileAndReturnFileUrl($request);
        ($request->has('file_upload_one')) ? $form->file_one_url = $fileUrl : $form->file_two_url = $fileUrl;
        $form->save();
        return response()->json($form, 201);
    }

    public function storeAdditional(Request $request, Form $form)
    {
        // $fileUrl = $this->uploadAddiionalFileAndReturnFileUrl($request);

        /**
         * Additional Files should be an array of objects serialezed
         * Make sure to serialize when saving
         *
         */
        $additionalFileObject = new stdClass();
        $additionalFileObject->id = uniqid();
        // $additionalFileObject->url = $fileUrl;
        $additionalFileObject->url = 'peanut-is-hairy';
        // return response()->json($additionalFileObject, 201);

        if (is_null($form->additional_files) || $form->additional_files === "") {
            /**
             * Encode new object and save
             * Send new local object
             */
            $newFileObjectsArr = [];
            array_push($newFileObjectsArr, $additionalFileObject);
            $form->additional_files = json_encode($newFileObjectsArr);
            $form->save();
            return response()->json(['m' => 'Additional files empty', 'k' => $form->id, 'p' => $newFileObjectsArr], 201);
        } else {
            /**
             * Decode
             * Encode new object and save
             * Send new local objects
             */
            $decoded = json_decode($form->additional_files);
            array_push($decoded, $additionalFileObject);
            $form->additional_files = json_encode($decoded);
            $form->save();
            return response()->json(['m' => 'Found additional files', 'k' => $form->id, 'p' => $additionalFileObject], 201);
        }

    }

    public function updateAdditional(Request $request, Form $form)
    {
        $form->additional_files = $request->additional_files;
        $form->save();
        return response()->json('success. record updated!', 201);
    }

    public function decodeBase64ImageAndStore(Request $request)
    {
        $image = $request->b64;
        preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
        $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
        $image = str_replace(' ', '+', $image);
        $imageName = 'image_' . uniqid() . '_' . time() . '.' . $image_extension[1]; //generating unique file name;
        $decodedBase64 = base64_decode($image);

        // Store
        Storage::disk('s3')->put('company_forms' . '/' . $imageName, $decodedBase64);
        // Get URL
        $fileUrl = Storage::disk('s3')->url('company_forms') . '/' . $imageName;
        return response()->json(['image' => $fileUrl], 200);
    }

    /**
     * @param Request $request
     */
    private function uploadFileAndReturnFileUrl(Request $request)
    {
        $file = ($request->has('file_upload_one')) ? $request->file_upload_one : $request->file_upload_two;
        $fileExtension = $file->getClientOriginalExtension();
        $imageName = Carbon::now()->timestamp . $file->getClientOriginalName();
        Storage::disk('s3')->putFileAs('company_forms', $file, $imageName);
        $fileUrl = Storage::disk('s3')->url('company_forms') . '/' . $imageName;
        return $fileUrl;
    }

    private function uploadAddiionalFileAndReturnFileUrl(Request $request)
    {
        $file = ($request->has('file_upload_additional')) ? $request->file_upload_additional : null;
        $fileExtension = $file->getClientOriginalExtension();
        $imageName = Carbon::now()->timestamp . $file->getClientOriginalName();
        Storage::disk('s3')->putFileAs('company_forms', $file, $imageName);
        $fileUrl = Storage::disk('s3')->url('company_forms') . '/' . $imageName;
        return $fileUrl;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Form $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        //
    }

    /****/
    public function destroyFile(Request $request, Form $form)
    {
        try {
            if ($request->selected === 1) {
                // Update file 1
                $form->file_one_url = null;
            } else {
                // Update file 2
                $form->file_two_url = null;
            }
            $form->save();
            Storage::disk('s3')->delete('company_forms/' . $request->f);
            return response()->json($form, 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 201);
        }
    }
}
