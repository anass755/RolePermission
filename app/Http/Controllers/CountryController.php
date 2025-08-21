<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries',
        ]);

        Country::create($request->all());
        
        return redirect()->route('countries.index')
                        ->with('success', 'Country created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:countries,code,' . $country->id,
        ]);

        $country->update($request->all());
        
        return redirect()->route('countries.index')
                        ->with('success', 'Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        // Check if country has any states (direct relationship check)
        if ($country->states()->exists()) {
            return redirect()->route('countries.index')
                           ->with('error', 'Cannot delete country. It has ' . $country->states()->count() . ' associated states.');
        }

        // If no states exist, safe to delete
        $country->delete();
        
        return redirect()->route('countries.index')
                        ->with('success', 'Country deleted successfully.');
    }
}