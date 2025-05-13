<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemFile\{SystemFileStore,SystemFileUpdate};
use App\Http\Resources\SystemFile\SystemFileResource;
use App\Models\SystemAttachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as parentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class SystemFileController extends Controller
{
    public function __construct() {
            $this->middleware('auth:api' , ['except' => 'index']);
    }
   
    public function index(): JsonResponse
    {
        $system_files = SystemAttachment::all();
        return SystemFileResource::collection($system_files)->response();

         //return system file with relation
        // $system_files = SystemAttachment::with(['uploadByUser', 'request'])->get();
        // return SystemFileResource::collection($system_files)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SystemFileStore $request, $request_id)
    {
        $validated = $request->validated();
    
        try {
            $systemFiles = []; // Initialize an array to hold all created files
    
            if ($request->hasFile('systemFiles')) {
                foreach ($request->file('systemFiles') as $file) {
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('systemFiles', $fileName, 'public');
    
    
                    $systemFiles[] = SystemAttachment::create([
                        'uploaded_by' => Auth::guard('api')->user()->id,
                        'request_id' => $request_id,
                        'file_path' => $filePath,
                    ]);
                }
            }
    
            // Check if any files were uploaded
            if (empty($systemFiles)) {
                return response()->json([
                    'message' => 'لم يتم تحميل أي ملفات'

                ], 200);
            }
    
            // Return the collection of all created files
            return SystemFileResource::collection($systemFiles)->additional([
                'message' => 'تم رفع الملفات بنجاح'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فشل في تحميل الملفات: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SystemFileUpdate $request, $request_id)
    {
        
       $systemAttachments = SystemAttachment::findOrFail($request_id)->get();
       
       if($request->hasFile('systemFiles')) {
            foreach($systemAttachments as $attachment){

                    Storage::disk('public')->delete($attachment->file_path);
                     $attachment->delete();
                     

            } 
       }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
