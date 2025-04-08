<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Traking\TrakingStore;
use App\Http\Requests\Traking\TrakingUpdate;
use App\Http\Resources\Traking\TrakingResource;

class TrakingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['index','show']]);
    }


    public function index(): JsonResponse
    {
        $trackings = Tracking::with([ 'requests','updatedByUser','request_status'])->paginate(10);
        return TrakingResource::collection($trackings)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrakingStore $request): JsonResponse
    {
        $trackings = Tracking::create($request->validated());
        return (new TrakingResource($trackings))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $tracking = Tracking::findOrFail($id);
        return (new TrakingResource($tracking))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrakingUpdate $request, string $id): JsonResponse
    {
       $tracking = Tracking::findOrFail($id);
       $tracking->update($request->validated());
       return (new TrakingResource($tracking->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tracking = Tracking::findOrFail($id);
        $tracking->delete();

        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $tracking
        ], 200);
    }
}
