<?php

namespace App\Http\Controllers;

use App\Models\Branche;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Branch\BranchResource;
use App\Http\Requests\Branch\StoreBranchRequest;
use App\Http\Requests\Branch\UpdateBranchRequest;


class BranchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['index','show','store']]);
    }

   /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $branchs = Branche::paginate(10);
        return BranchResource::collection($branchs)->response();
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreBranchRequest $request): JsonResponse
    {
        $branch = Branche::create($request->validated());
        return (new BranchResource($branch))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
  
    public function show(Branche $branch): JsonResponse
    {
        return (new BranchResource($branch))->response();
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateBranchRequest $request, Branche $branch): JsonResponse
    {
        $branch->update($request->validated());
        return (new BranchResource($branch->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Branche $branch): JsonResponse
    {
        $branch->delete();

        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $branch
        ], 200);
    }
}
