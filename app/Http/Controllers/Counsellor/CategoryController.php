<?php

namespace App\Http\Controllers\Counsellor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return $this->successResponse('All categories', $categories);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Category::create([
            'name' => $request->name,
            'counsellor_id' => auth()->id()
        ]);

        return $this->createdResponse('Category saved', $category);
    }

    public function update(Request $request, $categoryId)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Category::findOrFail($categoryId);

        $category->update($request->only('name'));

        return $this->successResponse('Category updated', $category);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return $this->successResponse('Showing category', $category);
    }
}
