<?php

namespace App\Http\Controllers\Api;

use App\Models\Person;
use App\Models\Company;
use App\Models\Civility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Models\Departement;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return PersonResource::collection(Person::all());
        return PersonResource::collection(Person::with(['company', 'civility', 'departements'])->paginate(6));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'civility_id' => 'required',
        ]);
        $civility = Civility::findOrFail($request->civility_id);

        $person = Person::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);
        
        $person->civility()->associate($civility);
        $person->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return PersonResource::make($person->with(['company', 'civility', 'departements'])->where('id', '=', $person->id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'civility_id' => 'required',
            'email' => 'nullable|email:rfc,dns',
            // 'phone' => 'nullable|min_digits:10|numeric'
        ]);

        $civility = Civility::find($request->civility_id);
        if ($civility !== null) {
            $person->civility()->associate($civility);  
        } 

        if ($request->company_id === null) {
            $person->company()->dissociate();
        }
        $company = Company::find($request->company_id);
        if ($company !== null) {
            $person->company()->associate($company);
        }

        $person->departements()->sync($request->departements);


        $person->save();

        // we update all the classics values
        $person->update($request->only(['firstname', 'lastname', 'email', 'phone']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->delete();
    }
}
