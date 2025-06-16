<?php

namespace App\Http\Controllers;

use App\Models\SoftwareLicense;
use Illuminate\Http\Request;

class SoftwareLicenseController extends Controller
    public function __construct()
        $this->middleware('auth');
        $this->middleware('role:Admin');
        $this->middleware('role:IT Manager');
    {
    }
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(SoftwareLicense $softwareLicense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SoftwareLicense $softwareLicense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SoftwareLicense $softwareLicense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SoftwareLicense $softwareLicense)
    {
        //
    }
}
