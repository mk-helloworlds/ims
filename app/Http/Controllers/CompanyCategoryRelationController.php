<?php

namespace App\Http\Controllers;

use App\Models\CompanyCategoryRelation;
use App\Http\Requests\StoreCompanyCategoryRelationRequest;
use App\Http\Requests\UpdateCompanyCategoryRelationRequest;
use App\Models\Category;
use App\Models\Company;

class CompanyCategoryRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load 'company' and 'category' relationships
        $results = CompanyCategoryRelation::with(['company', 'category'])->paginate(10);

        return view('back_end.preference.company_category_relation.index')->with(['results' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $categories = Category::all();

        return view('back_end.preference.company_category_relation.create', compact('companies','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyCategoryRelationRequest $request)
    {
        $request->validate([
            'company_id' => 'required',
            'category_id' => 'required',
        ]);

        $companyCategoryRelation = CompanyCategoryRelation::create([
            'company_id' => $request->input('company_id'),
            'category_id' => $request->input('category_id'),
        ]);

        if($companyCategoryRelation){
            return redirect()->route("company_category_relation.index")->with('success','User created successfully.');
        }
        return back()->with('error', 'User Can not be created, Please try again.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyCategoryRelation $companyCategoryRelation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyCategoryRelation $company_category_relation)
    {

        $companies = Company::all();
        $categories = Category::all();

        return view('back_end.preference.company_category_relation.edit', compact('companies','categories','company_category_relation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyCategoryRelationRequest $request, CompanyCategoryRelation $companyCategoryRelation)
    {
        $request->validate([
            'company_id' => 'required',
            'category_id' => 'required',
        ]);

        $companyCategoryRelation->company_id = $request->input('company_id');
        $companyCategoryRelation->category_id = $request->input('category_id');

        if($companyCategoryRelation->save()){
            return redirect()->route("company_category_relation.index")->with('success','Company Category Relations created successfully.');
        }
        return back()->with('error', 'Company Category Relations Can not be created, Please try again.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyCategoryRelation $company_category_relation)
    {
        $company_category_relation->delete();
        return redirect()->route('company_category_relation.index')->with('success', 'Company Category Relations Deleted successfully');
    }
}
