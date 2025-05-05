<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Resources\Applicant\ApplicantResource;
use App\Http\Requests\Applicant\StoreApplicantRequest;
use App\Http\Requests\Applicant\UpdateApplicantRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApplicantController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // تحديد عدد العناصر في الصفحة (القيمة الافتراضية: 10)
        $perPage = $request->input('per_page', 10);
    
        // الحصول على البيانات مع التصفح
        $applicants = Applicant::paginate($perPage);
    
        // إعادة النتائج مع تنسيق الـ Resource
        return ApplicantResource::collection($applicants)->response();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantRequest $request): JsonResponse
    {
        $applicant = Applicant::create($request->validated());
        return (new ApplicantResource($applicant))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant): JsonResponse
{
    return (new ApplicantResource($applicant))->response();
}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantRequest $request, Applicant $applicant): JsonResponse
    {
        $applicant->update($request->validated());
        return (new ApplicantResource($applicant->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant): JsonResponse
    {
        $applicant->delete();
        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $applicant
        ], 200);
    }

}
