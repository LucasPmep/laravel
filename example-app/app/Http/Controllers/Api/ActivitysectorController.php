<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Activitysector;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitysectorResource;

class ActivitysectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ActivitysectorResource::collection(Activitysector::with(['companies',])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Activitysector $activitysector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activitysector $activitysector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activitysector $activitysector)
    {
        //
    }
}
