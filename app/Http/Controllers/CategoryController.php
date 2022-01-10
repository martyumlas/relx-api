<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::when($search, function ($query) use ($search) {
            $query->where('name', 'like', $search .'%');
        })->latest()->paginate(5);

        return CategoryResource::collection($categories);
    }

    public function create(StoreCategoryRequest $request)
    {
        $category = Category::create($request->safe()->only(['name', 'description']));

        return response()->json(['category' => $category, 'message' => 'Category created']);
    }

    public function update(Category $category, UpdateCategoryRequest $request) 
    {       
        $category->update($request->safe()->only(['name', 'description']));

        return response()->json(['category' => $category, 'message' => 'Category updated']);
    }

    public function show(Category $category)
    {
        return response()->json(['category' => $category ]);
    }

    public function delete(Category $category)
    {
        try {
            $category->delete();
            return response()->json(['message' => 'Category deleted']);
        } catch(\Exception $exception) {
            return response()->json($exception->getMessage());
        }        
    }
}
