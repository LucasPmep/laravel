<?php

namespace App\Http\Controllers\Api;

use App\Models\Person;
use App\Models\Company;
use App\Models\Civility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return PersonResource::collection(Person::all());
        return PersonResource::collection(Person::with(['company', 'civility', 'departements'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        Person::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return PersonResource::make($person->with(['company', 'civility', 'departements'])->where('id', '=', $person->id)->first());

        // return PersonResource::make($person::with(['company', 'civility', 'departements'])->get());
        // return PersonResource::make($person)->with(['company', 'civility', 'departements']);
        // return PersonResource::collection(Person::with(['company', 'civility', 'departements'])->get());
        // ->where('id', $person)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $civility = Civility::findOrFail($request->civility_id);
        $person->civility()->associate($civility);
        $person->save(); // if we are in a many to many relationship, we can use the saveMany() function

        $company = Company::findOrFail($request->company_id);
        $person->company()->associate($company);
        $person->save(); // if we are in a many to many relationship, we can use the saveMany() function
        
        // we update all the classics values
        $person->update($request->only(['firstname', 'lastname', 'email', 'phone']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        //
    }
}
