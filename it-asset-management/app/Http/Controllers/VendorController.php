<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function __construct()
    {
        \$this->middleware('auth');
        // Example: Admin or IT Manager can manage vendors
        \$this->middleware('role:Admin')->except(['index', 'show']);
        \$this->middleware('role:IT Manager')->except(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \$vendors = Vendor::latest()->get();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request)
    {
        \$validator = Validator::make(\$request->all(), [
            'name' => 'required|string|max:255|unique:vendors,name',
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:vendors,email',
            'products_services_supplied' => 'nullable|string',
            'sla_terms' => 'nullable|string',
            'escalation_matrix' => 'nullable|string',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('vendors.create')
                        ->withErrors(\$validator)
                        ->withInput();
        }

        Vendor::create(\$request->all());

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor \$vendor)
    {
        return view('vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor \$vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, Vendor \$vendor)
    {
        \$validator = Validator::make(\$request->all(), [
            'name' => 'required|string|max:255|unique:vendors,name,' . \$vendor->id,
            'address' => 'nullable|string',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255|unique:vendors,email,' . \$vendor->id,
            'products_services_supplied' => 'nullable|string',
            'sla_terms' => 'nullable|string',
            'escalation_matrix' => 'nullable|string',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('vendors.edit', \$vendor->id)
                        ->withErrors(\$validator)
                        ->withInput();
        }

        \$vendor->update(\$request->all());

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor \$vendor)
    {
        try {
            // Check for related records before deleting if necessary
            // For example, if purchases or licenses are linked, you might prevent deletion
            // or handle it gracefully (e.g., set vendor_id to null if allowed).
            // if (\$vendor->purchases()->count() > 0 || \$vendor->softwareLicenses()->count() > 0) {
            //     return redirect()->route('vendors.index')->with('error', 'Cannot delete vendor. It is linked to existing purchases or licenses.');
            // }
            \$vendor->delete();
            return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
        } catch (\Illuminate\Database\QueryException \$e) {
            // Catch generic database query exception (e.g., foreign key constraint violation)
            return redirect()->route('vendors.index')->with('error', 'Cannot delete vendor. It may be linked to other records.');
        }
    }
}
