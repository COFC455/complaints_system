<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Request\RequestStore;
use App\Http\Requests\Request\{RequestUpdate,StoreOnlyRequest};
use App\Http\Resources\Request\RequestResource;
use App\Models\Request as RequestModel;
use App\Models\{Applicant,ApplicantAttachment,request_types,RequestStatus};
use App\Http\Requests\Request\CheckSatusRequest;


class RequestController extends Controller
{

    public function _construct() {
        $this->middleware('auth:api', [ 'expect' => ['index' , 'show','store','getRequestByReferenceCode']]);
    }

    // public function index(): JsonResponse
    // {

    //     // $requests = Request::with(['applicant', 'category', 'branch', 'request_type', 'request_status','applicant_attachments'])->paginate(10);
    //     // return RequestResource::collection($requests)->response();

    // }

        public function index(HttpRequest $httpRequest)
        {
            $query = RequestModel::query();

            // الفلترة حسب request_type (request_type_id)
            if ($httpRequest->has('request_type')) {
                $query->where('request_type_id', $httpRequest->input('request_type'));
            }

            // الفلترة حسب request_status (request_status_id)
            if ($httpRequest->has('request_status')) {
                $query->where('request_status_id', $httpRequest->input('request_status'));
            }

            // الفلترة حسب category (category_id)
            if ($httpRequest->has('category')) {
                $query->where('category_id', $httpRequest->input('category'));
            }

            // الفلترة حسب request_status (branch_id)
            if ($httpRequest->has('branch')) {
                $query->where('branch_id', $httpRequest->input('branch'));
            }

            //filter cocenred
            if($httpRequest->has('concerned_entities')){
                $query->where('concerned_entities', $httpRequest->input('concerned_entities'));
            }


            $perPage = $httpRequest->input('per_page', 10);

            $requests = $query->with(['applicant', 'category', 'branch', 'request_type', 'request_status', 'city','user'])
                            ->paginate($perPage);



            return response()->json($requests);

        }



        //getTotalRequests
        public function getTotalRequests(): JsonResponse
        {
            // حساب عدد الطلبات بدون أي فلترة
            $totalRequests = RequestModel::count();

            return response()->json([
                'status' => 'success',
                'total_requests' => $totalRequests
            ]);
        }



        //get count request type complaints
        public function getComplaintsCount(): JsonResponse
        {
            // البحث عن ID نوع "شكوى"
            $complaintType = request_types::where('type_name', 'شكوى')->first();

            if (!$complaintType) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'نوع الطلب "شكوى" غير موجود'
                ], 404);
            }

            // حساب عدد الطلبات من نوع شكوى
            $count = RequestModel::where('request_type_id', $complaintType->id)->count();

            return response()->json([
                'status' => 'success',
                'complaints_count' => $count
            ]);
        }


          //get count request status = Resolved
          public function getResolvedCount(): JsonResponse
          {

              $StatusType = RequestStatus::where('status_name', 'تم الحل')->first();

              if (!$StatusType) {
                  return response()->json([
                      'status' => 'error',
                      'message' => 'حالة الطلب "تم الحل" غير موجود'
                  ], 404);
              }

              // حساب عدد الطلبات من نوع شكوى
              $count = RequestModel::where('request_status_id', $StatusType->id)->count();

              return response()->json([
                  'status' => 'success',
                  'Resolved_count' => $count
              ]);
          }


          

    public function storeOnly(StoreOnlyRequest $request): JsonResponse
    {
        $request = Request::create($request->validated());
        return (new RequestResource($request))->response()->setStatusCode(201);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestStore $request): JsonResponse
    {

        // بدء المعاملة
        \DB::beginTransaction();
        try {
            // تحويل الـ JSON إلى مصفوفة
            $jsonData = json_decode($request->input('data'), true);

            // تحقق من صحة الحقول الداخلية
            $validator = Validator::make($jsonData, [
                // بيانات مقدم الطلب (applicants)
                'applicant.full_name' => 'required|string|max:255',
                'applicant.email' => 'required|email',
                'applicant.phone' => 'required|string|max:20',
                'applicant.mobile_phone' => 'required|string|max:20',
                'applicant.address' => 'required|string',
                'applicant.national_id' => 'required|string|unique:applicants,national_id|max:50',

                // بيانات الطلب (requests)
                'request.category_id' => 'required|exists:categories,id',
                'request.branch_id' => 'required|exists:branches,id',
                'request.user_id' => 'exists:users,id',
                'request.request_type_id' => 'required|exists:request_types,id',
                'request.request_status_id' => 'required|exists:request_statuses,id',
                'request.city_id' => 'required|exists:cities,id',
                'request.description' => 'required|string|max:500',
                'request.reference_code' => 'required|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // 1. حفظ بيانات مقدم الطلب
            $applicant = Applicant::create($jsonData['applicant']);

            // 2. حفظ بيانات الطلب
            $requestData = $applicant->requests()->create($jsonData['request']);

            // 3. حفظ المرفقات إذا وجدت
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('attachments', $fileName, 'public');

                    ApplicantAttachment::create([
                        'applicant_id' => $applicant->id,
                        'request_id' => $requestData->id,
                        'file_path' => $filePath,
                    ]);
                }
            }

            // جلب البيانات مع العلاقات
            $requestWithRelations = RequestModel::with([
                'applicant',
                'category',
                'branch',
                'request_type',
                'request_status',
                'applicant_attachments'
            ])->findOrFail($requestData->id);

            // إتمام المعاملة بنجاح
            \DB::commit();

            return (new RequestResource($requestWithRelations))
                ->response()
                ->setStatusCode(201);

        } catch (\Exception $e) {
            // التراجع عن المعاملة في حالة الخطأ
            \DB::rollBack();

            return response()->json([
                'error' => 'فشل في إنشاء الطلب: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        $request = RequestModel::findOrFail($id);
        return (new RequestResource($request))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestUpdate $request, $id): JsonResponse
    {

        \DB::beginTransaction();
        try {
            $requestModel = RequestModel::findOrFail($id);
            // الحصول على البيانات المفحوصة
            $validated = $request->validated();

            // تحديث بيانات مقدم الطلب إذا أُرسلت
            if (isset($validated['applicant'])) {
                $requestModel->applicant->update($validated['applicant']);
            }

            // تحديث بيانات الطلب إذا أُرسلت
            if (isset($validated['request'])) {
                $requestModel->update($validated['request']);
            }

            // معالجة المرفقات الجديدة
            if ($request->hasFile('attachments')) {
                // حذف المرفقات القديمة (اختياري)
                ApplicantAttachment::where('request_id', $requestModel->id)->delete();

                foreach ($request->file('attachments') as $file) {
                    $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('attachments', $fileName, 'public');

                    ApplicantAttachment::create([
                        'applicant_id' => $requestModel->applicant_id,
                        'request_id' => $requestModel->id,
                        'file_path' => $filePath,
                    ]);
                }
            }

            // جلب البيانات المحدثة مع العلاقات
            $updatedRequest = RequestModel::with([
                'applicant',
                'category',
                'branch',
                'request_type',
                'request_status',
                'applicant_attachments'
            ])->findOrFail($requestModel->id);

            \DB::commit();

            return (new RequestResource($updatedRequest))
                ->response()
                ->setStatusCode(200);

        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json([
                'error' => 'فشل في تحديث الطلب: ' . $e->getMessage(),
            ], 500);
        }
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
            $requestModel = RequestModel::findOrFail($id);

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


    public function getRequestByReferenceCode($reference_code)
    {
        // البحث عن الطلب باستخدام reference_code
        $request = RequestModel::with(['applicant', 'category', 'branch', 'request_type', 'request_status', 'city', 'applicant_attachments'])
                        ->where('reference_code', $reference_code)
                        ->first();

        if (!$request) {
            return response()->json([
                'success' => false,
                'message' => 'لم يتم العثور على أي طلبات'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => $request
        ]);
    }


}
