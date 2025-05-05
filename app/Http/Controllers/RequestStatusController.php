<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RStatus\RequestStatusStore;
use App\Http\Requests\RStatus\RequestStatusUpdate;
use App\Http\Resources\RStatus\RequestStatusResource;

class RequestStatusController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['index' , 'show']]);
    }
  

    public function index(Request $request) : JsonResponse
    {
        $perPage = $request->input('per_page', 10);
        $request_statues = RequestStatus::paginate($perPage);

        return RequestStatusResource::collection($request_statues)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestStatusStore $request): JsonResponse
    {
         $request_status = RequestStatus::create($request->validated());
         return (new RequestStatusResource($request_status))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        $request_status = RequestStatus::findOrFail($id);
        return (new RequestStatusResource($request_status))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestStatusUpdate $request, string $id): JsonResponse
    {
        $request_status = RequestStatus::findOrFail($id);
        $request_status->update($request->validated());
        return (new RequestStatusResource($request_status->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $request_status = RequestStatus::findOrFail($id);
        $request_status->delete();
        
        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $request_status
        ], 200);

    }
}
