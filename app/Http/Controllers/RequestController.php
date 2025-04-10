<?php

namespace App\Http\Controllers;


use App\Models\{Request,Applicant,ApplicantAttachment};
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Request\RequestStore;
use App\Http\Requests\Request\RequestUpdate;
use App\Http\Requests\Request\CheckSatusRequest;
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
        
        $existingRequest = Request::with('applicant_attachments')->findOrFail($id);

        // 1. تحديث بيانات مقدم الطلب (Applicant)
        $existingRequest->applicant->update($request->input('applicant'));

        // 2. تحديث بيانات الطلب (Request)
        $existingRequest->update([
            'category_id' => $request->input('request.category_id'),
            'branch_id' => $request->input('request.branch_id'),
            'request_type_id' => $request->input('request.request_type_id'),
            'request_status_id' => $request->input('request.request_status_id'),
            'description' => $request->input('request.description'),
            'reference_code' => $request->input('request.reference_code'),
        ]);

         // 3. حذف المرفقات القديمة والملفات المرتبطة بها
        if ($existingRequest->applicant_attachments->isNotEmpty()) {
            foreach ($existingRequest->applicant_attachments as $attachment) {
                // حذف الملف من التخزين
                Storage::disk('public')->delete($attachment->file_path);
                // حذف السجل من قاعدة البيانات
                $attachment->delete();
            }
        }

         // 4. حفظ المرفقات الجديدة
            try {
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                        $filePath = $file->storeAs('attachments', $fileName, 'public');

                        ApplicantAttachment::create([
                            'applicant_id' => $existingRequest->applicant->id,
                            'request_id' => $existingRequest->id,
                            'file_path' => $filePath,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'فشل في تحميل الملفات: ' . $e->getMessage(),
                ], 500);
            }


            $updatedRequest = Request::with([
                'applicant',
                'category',
                'branch',
                'request_type',
                'request_status',
                'applicant_attachments'
            ])->find($existingRequest->id);

        return (new RequestResource($updatedRequest))->response()->setStatusCode(200);
    }


  
    public function getAttachmentsByApplicantName(string $name): JsonResponse
    {
        // البحث عن المواطنين الذين يتطابق اسمهم مع الاسم المطلوب
        $applicants = Applicant::where('full_name', 'LIKE', "%{$name}%")->get();

        if ($applicants->isEmpty()) {
            return response()->json([
                'error' => 'لم يتم العثور على مواطن بهذا الاسم'
            ], 404);
        }

        // جمع جميع المرفقات من جميع المواطنين المطابقين
        $attachments = collect();
        foreach ($applicants as $applicant) {
            foreach ($applicant->attachments as $attachment) {
                $attachments->push([
                    'id' => $attachment->id,
                    'file_url' => asset('storage/' . $attachment->file_path),
                    'applicant_name' => $applicant->full_name,
                    'uploaded_at' => $attachment->uploaded_at,
                ]);
            }
        }

        return response()->json([
            'data' => $attachments
        ]);
    }


    //update status 

    public function updateStatus(CheckSatusRequest $request, $id)
        {
            // العثور على الطلب أو إرجاع خطأ 404
            $requestModel = Request::findOrFail($id);

            // التحقق من صحة القيمة المُرسلة
            $validated = $request->validated();
            // تحديث الحالة
            $requestModel->update([
                'status' => $validated['status'],
            ]);

            return response()->json([
                'message' => 'تم تحديث الحالة بنجاح',
                'data' => new RequestResource($requestModel),
            ]);
    }
   
}
