<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Request\RequestStore;
use App\Http\Requests\Request\RequestUpdate;
use App\Http\Resources\Request\RequestResource;

class RequestController extends Controller
{

    public function _construct() {
        $this->middleware('auth:api', [ 'expect' => ['index' , 'show']]);
    }

    public function index(): JsonResponse
    {
        $requests = Request::with(['applicant', 'category', 'branch', 'request_type', 'request_status'])->paginate(10);
        return RequestResource::collection($requests)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestStore $request): JsonResponse
    {

        $request = Request::create($request->validated());
        return (new RequestResource($request))->response()->setStatusCode(201);

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
