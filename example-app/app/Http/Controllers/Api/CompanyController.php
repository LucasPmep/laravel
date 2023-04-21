<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return CompanyResource::collection(Company::all());
        return CompanyResource::collection(Company::with(['people', 'activitysectors'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'postalcode' => 'required',
            'city' => 'required',
            'CA' => 'required',
        ]);

        Company::create([
            'name' => $request->name,
            'postalcode' => $request->postalcode,
            'city' => $request->city,
            'CA' => $request->CA,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}