<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Http\Requests\StoreInternshipRequest;
use App\Http\Requests\UpdateInternshipRequest;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function index()
    {
        $results = Internship::paginate(10);

        return view('back_end.preference.internship.index')->with(['results' => $results]);
    }

    public function create()
    {
        $internship = Internship::get();
        $results = Internship::paginate(10);

        $data = array(
            'internships' => $internship,
            'results' => $results,
        );

        // dd(Auth::check(), Auth::user());

        return view('back_end.preference.internship.create')->with($data);
    }
    public function store(StoreInternshipRequest $request)
    {

        $request->validate([
            'internship_title' => 'required|string|max:255',
            'type' => 'required|in:1,2',
            'period' => 'required|integer|min:1',
            'school' => 'required|in:DB,CS,TN',
            'generation' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $internship = new Internship([
            'internship_title' => $request->input('internship_title'),
            'type' => $request->input('type'),
            'period' => $request->input('period'),
            'school' => $request->input('school'),
            'generation' => $request->input('generation'),
            'description' => $request->input('description') ?? null,
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);


        // dd($internship);


        if($internship->save()){
            return redirect()->route('internship.index')->with('success', "internship created successfully!");
        }
        return back()->with('error','An error occureed with creating the internship');
    }

    public function show($id)
    {
        $internship = Internship::with('participants')->findOrFail($id);
        $participants = $internship->participants; // Retrieve all participants for this internship

        return view('back_end.preference.internship.show', compact('internship', 'participants'));
    }

    // public function show($id)
    // {
    //     $internship = Internship::with('participants')->findOrFail($id);
    //     $participants = $internship->participants; // Retrieve all participants for this internship

    //     return view('back_end.preference.internship.show', compact('internship', 'participants'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Internship $internship)
    {

        // dd(Auth::check() ,Auth::user());

        return view('back_end.preference.internship.edit', compact('internship'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInternshipRequest $request, Internship $internship)
    {
        $request->validate([
            'internship_title' => 'required|string|max:255',
            'type' => 'required|in:1,2',
            'period' => 'required|integer|min:1',
            'school' => 'required|in:DB,CS,TN',
            'generation' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // $internship = new Internship([
        //     'internship_title' => $request->input('internship_title'),
        //     'type' => $request->input('type'),
        //     'period' => $request->input('period'),
        //     'school' => $request->input('school'),
        //     'generation' => $request->input('generation'),
        //     'description' => $request->input('description') ?? null,
        //     'start_date' => $request->input('start_date'),
        //     'end_date' => $request->input('end_date'),
        // ]);

        $requestData = [];

        foreach ($request->all() as $key => $value) {
            if (! empty($value)) {
                $requestData[$key] = $value;
            }
        }

        // dd($internship);


        if($internship->update($requestData)){
            return redirect()->route('internship.index')->with('success', "internship updated successfully!");
        }
        return back()->with('error','An error occureed with updating the internship');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
    {
        $internship->delete();

        return redirect()->route('internship.index')->with('success','Internship Deleted Successfully!');
    }

    public function dashboard()
    {
        $internships = Internship::withCount('participants')->get();
        return view('dashboard', compact('internships'));
    }
}
