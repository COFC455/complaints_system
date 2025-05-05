<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\request_types;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Type\RequestTypeStore;
use App\Http\Requests\Type\RequestTypeUpdate;
use App\Http\Resources\Type\RequestTypeResource;

class RequestTypeController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['index','show']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $perPage = $request->input('per_page', 10);
       $request_types = request_types::paginate($perPage);
       return RequestTypeResource::collection($request_types)->response();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestTypeStore $request): JsonResponse
    {
        $request_types = request_types::create($request->validated());
        return (new RequestTypeResource($request_types))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $request_type = request_types::findOrFail($id);
        return (new RequestTypeResource($request_type))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestTypeUpdate $request, $id): JsonResponse
    {
        $request_type = request_types::findOrFail($id);
        $request_type->update($request->validated());
        return (new RequestTypeResource($request_type->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $request_type = request_types::findOrFail($id);
        $request_type->delete();
        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $request_type
        ], 200);
    }
}
