<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Contracts\View\View;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $results = Company::paginate(10);
        return view('back_end.preference.company.index')->with(['results' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        $data = array(
            'category' => $categories,
        );

        return view('back_end.preference.company.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        // Validate the input
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_profile' => 'required|string',
            'category_id' => 'required',
        ]);

        // Assign the new input to the variable prepare for inputing to the Model
        $company = new Company([
            'company_name' => $request->input('company_name'),
            'company_profile' => $request->input('company_profile'),
            'category_id' => $request->input('category_id'),
        ]);

        if($company->save()){
            return redirect()->route('company.index')->with('success', 'Company Created Successfully');
        }

        return back()->with('error', 'User Can not be created, Please try again.');
    }

    public function storeAjax(StoreCompanyRequest $request)
    {
        // Validate the input
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_profile' => 'required|string',
            'category_id' => 'required',
        ]);

        // Create a new company
        $company = Company::create([
            'company_name' => $request->input('company_name'),
            'company_profile' => $request->input('company_profile'),
            'category_id' => $request->input('category_id'),
        ]);

        if($company->save()){
            // return redirect()->route('submission_form.create')->with('success', 'Company Created Successfully');

            return response()->json([
                'id' => $company->id,
                'company_name' => $company->company_name,
                'message' => 'Company created successfully!'
            ]);
        }
        return response()->json([
            'error' => 'Company could not be created. Please try again.'
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $categories = Category::get();

        $data = array(
            'category' => $categories,
        );

        return view("back_end.preference.company.edit", compact('company'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        // Validate the input
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_profile' => 'required|string',
            'category_id' => 'required',
        ]);

        $company->company_name = $request->input('company_name');
        $company->company_profile = $request->input('company_profile');
        $company->category_id = $request->input('category_id');
        

        if($company->save()){
            return redirect()->route('company.index')->with('success', 'Company Created Successfully');
        }

        return back()->with('error', 'User Can not be created, Please try again.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('company.index')->with('success', 'User Deleted successfully!');
    }
}
