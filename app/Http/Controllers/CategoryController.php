<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Category::paginate(10);
        return view("back_end.preference.category.index")->with(['results' => $results]);;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('back_end.preference.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->validate([
            "category_name" => "required|string|max:255",
        ]);
        
        $category = Category::create([
            'category_name' => $request->input('category_name'),
        ]);

        if($category){
            return redirect()->route('category.index')->with('success', 'Category created successfully!');
        }
        return back()->with('error', 'Fail to create caregory, please try again.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('back_end.preference.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $request->validate([
            "company_name" => "string|max:255",
        ]);

        $category->category_name = $request->input('category_name');

        if($category->save()){
            return redirect()->route('category.index')->with('success', 'Category Updated Successfully');
        }
        return back()->with('error', 'Can not update the category');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category Deleted Successfully!');
    }
}
