<?php

namespace App\Http\Controllers\Api;

use App\Models\Person;
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
        return PersonResource::make($person->with('company')->first());

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
