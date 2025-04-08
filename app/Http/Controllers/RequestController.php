<?php

namespace App\Http\Controllers;

use App\Models\{Request,Applicant,ApplicantAttachment};
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Request\RequestStore;
use App\Http\Requests\Request\RequestUpdate;
use App\Http\Resources\Request\RequestResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RequestController extends Controller
{

    public function _construct() {
        $this->middleware('auth:api', [ 'expect' => ['index' , 'show','store']]);
    }

    public function index(): JsonResponse
    {
        $requests = Request::with(['applicant', 'category', 'branch', 'request_type', 'request_status','applicant_attachments'])->paginate(10);
        return RequestResource::collection($requests)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestStore $request): JsonResponse
    {

        // 1. حفظ بيانات مقدم الطلب (Applicant)
        $applicant = Applicant::create($request->input('applicant'));

        // 2. حفظ بيانات الطلب (Request)
        $requestData = $applicant->requests()->create([
            // 'applicant_id' => $applicant->id,
            'category_id' => $request->input('request.category_id'),
            'branch_id' => $request->input('request.branch_id'),
            'request_type_id' => $request->input('request.request_type_id'),
            'request_status_id' =>$request->input('request.request_status_id'), // حالة افتراضية
            'description' => $request->input('request.description'),
            'reference_code' => $request->input('request.reference_code'),
        ]);

        // 3. حفظ المرفقات (Attachments)
       // تخزين الملفات
        try {
            $attachments = [];

            foreach ($request->file('attachments') as $file) {
                // توليد اسم فريد للملف
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

                // حفظ الملف في المجلد: storage/app/public/attachments
                $filePath = $file->storeAs('attachments', $fileName, 'public');

                // حفظ البيانات في جدول applicant_attachments
                $attachment = ApplicantAttachment::create([
                    'applicant_id' => $applicant->id, // من السجل الذي تم إنشاؤه مسبقًا
                    'request_id' => $requestData->id, // من السجل الذي تم إنشاؤه مسبقًا
                    'file_path' => $filePath,
                ]);

            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'فشل في تحميل الملفات: ' . $e->getMessage(),
            ], 500);
        }

        $requestWithRelations = Request::with([
            'applicant',
            'category',
            'branch',
            'request_type',
            'request_status',
            'applicant_attachments'
        ])->find($requestData->id);

        return (new RequestResource($requestWithRelations))->response()->setStatusCode(201);

    }

    public function show(string $id)
    {
        $request = Request::findOrFail($id);
        return (new RequestResource($request))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestUpdate $request, string $id): JsonResponse
    {
        $request2 = Request::findOrFail($id);
        $request2->update($request->validated());
        return (new RequestResource($request2->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $request = Request::findOrFail($id);
        $request->delete();

        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $request
        ], 200);
    }
}
