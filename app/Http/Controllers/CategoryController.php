<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $categories = Category::when($search, function ($query) use ($search) {
            $query->where('name', 'like', $search .'%');
        })->latest()->paginate(5);

        return new CategoryCollection($categories);
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
        return response()->json(['category' => new CategoryResource($category)]);
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
