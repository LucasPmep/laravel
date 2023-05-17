<?php

namespace App\Http\Controllers\Api;

use App\Models\Person;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Pipes\Companies\QueryFilter;
use Illuminate\Pipeline\Pipeline;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Pipes\Companies\ActivitySectorsFilter;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return CompanyResource::collection(Company::with(['people', 'activitysectors'])->get());

        if (request()->has('fullget') && request('fullget') != null) {
            return CompanyResource::collection(Company::with(['people', 'activitysectors'])->get());
        }

        $companies = app(Pipeline::class)
        ->send(Company::query()->with(['people', 'activitysectors']))
        ->through([
            QueryFilter::class,
            ActivitySectorsFilter::class,
        ])
        ->thenReturn()
        ->select('companies.id', 'name', 'postalcode', 'city', 'CA')
        ->paginate(4);
        return $companies;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'postalcode' => 'required|min_digits:4|max_digits:6',
            'city' => 'required|max:255',
        ]);

        Company::create([
            'name' => $request->name,
            'postalcode' => $request->postalcode,
            'city' => $request->city,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return CompanyResource::make($company->with(['people', 'activitysectors'])->where('id', '=', $company->id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|max:255',
            'postalcode' => 'required|min_digits:4|max_digits:6',
            'city' => 'required|max:255',
            'CA' => 'nullable|numeric'
        ]);
        

        $company->people()->update(['company_id' => null]);

        if ($request->people) {
            $people = array_unique($request->people);
            
            foreach ($people as $person) {   
                $addingPerson = Person::find($person);
                $company->people()->save($addingPerson); 
            }
        }

        // $company->people()->update(['company_id' => $request->id]);
        // dont know why this doesnt work

        $company->activitysectors()->sync($request->activitysectors);
        $company->save();

        $company->update($request->only(['name', 'postalcode', 'city', 'CA']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
    }
}