<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;



class CategoryController extends Controller
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
        $perPage = $request->input('per_page', 10);
        $categories = Category::paginate($perPage);
        return CategoryResource::collection($categories)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $categories = Category::create($request->validated());
        return (new CategoryResource($categories))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {

        $categories = Category::findOrFail($id);
        return (new CategoryResource($categories))->response();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        $categories = Category::findOrFail($id);
        $categories->update($request->validated());
        return (new CategoryResource($categories->refresh()))->response();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $categories = Category::findOrFail($id);
        
        $categories->delete();

        return response()->json([
            'message' => 'deleted successfuly',
            'deleted_item' => $categories
        ], 200);

    }
}
