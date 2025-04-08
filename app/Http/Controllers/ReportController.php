<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Report\ReportStore;
use App\Http\Requests\Report\ReportUpdate;
use App\Http\Resources\Report\ReportResource;

class ReportController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index' , 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse

    {

        $reports = Report::with('generatedUser')->paginate(10);

        return ReportResource::collection($reports)->response();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReportStore $request)
    {
        $validated = $request->validated();

        // إذا أرسل العميل `data` ككائن (object)، حوله إلى سلسلة JSON
        if (is_array($validated['data'])) {
            $validated['data'] = json_encode($validated['data']);
        }

        $report = Report::create($validated);
         return (new ReportResource($report))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $report = Report::findOrFail($id);
        return (new ReportResource($report))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReportUpdate $request, string $id)
    {
        $report = Report::findOrFail($id);

        $validated = $request->validated();

        // إذا كانت القاعدة `json`، حول الكائن إلى سلسلة
        if (is_array($validated['data'])) {
            $validated['data'] = json_encode($validated['data']);
        }

        $report->update($validated);

        return (new ReportResource($report->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $report
        ], 200);
    }
}
