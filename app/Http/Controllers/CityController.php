<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\City\CityResource;
use App\Http\Requests\City\CityRequestStore;
use App\Http\Requests\City\CityRequestUpdate;

class CityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api',['except' => ['index','show']]);
    }


    public function index(): JsonResponse
    {
        $cities = City::paginate(10);
        return CityResource::collection($cities)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequestStore $request): JsonResponse
    {
        $city = City::create($request->validated());
        return (new CityResource($city))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $city = City::findOrFail($id);
        return (new CityResource($city))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequestUpdate $request, string $id): JsonResponse
    {
        $city = City::findOrFail($id);
        $city->update($request->validated());
        return (new CityResource($city->refresh()))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $city = City::findOrFail($id);

        $city->delete();

        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $city
        ], 200);
    }
}
