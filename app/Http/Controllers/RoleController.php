<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Role\RoleStore;
use App\Http\Requests\Role\RoleUpdate;
use App\Http\Resources\Role\RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
       $roles = Role::paginate(10);
       return RoleResource::collection($roles)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStore $request): JsonResponse
    {
        $role = Role::create($request->validated());
        return (new RoleResource($role))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
       $role = Role::findOrFail($id);
       return (new RoleResource($role))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdate $request, string $id)
    {
        $role = Role::findOrFail($id);

        $role->update($request->validated());

        return (new RoleResource($role->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $role
        ], 200);
    }
}
