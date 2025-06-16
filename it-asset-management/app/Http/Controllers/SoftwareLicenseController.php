<?php

namespace App\Http\Controllers;

use App\Models\SoftwareLicense;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SoftwareLicenseController extends Controller
{
    public function __construct()
    {
        \$this->middleware('auth');
        // Example: Admin or IT Manager can manage software licenses
        \$this->middleware('role:Admin')->except(['index', 'show']);
        \$this->middleware('role:IT Manager')->except(['destroy']); 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \$software_licenses = SoftwareLicense::with('vendor')->latest()->get();
        return view('software_licenses.index', compact('software_licenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \$vendors = Vendor::all();
        return view('software_licenses.create', compact('vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request)
    {
        \$validator = Validator::make(\$request->all(), [
            'software_name' => 'required|string|max:255',
            'version' => 'nullable|string|max:100',
            'license_key' => 'nullable|string|max:255|unique:software_licenses,license_key',
            'number_of_licenses' => 'nullable|integer|min:0', // 0 might mean unlimited/site license
            'activation_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:activation_date',
            'vendor_id' => 'nullable|exists:vendors,id',
            'support_contact_info' => 'nullable|string|max:255',
            'linked_office_location' => 'nullable|string|max:255',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('software_licenses.create')
                        ->withErrors(\$validator)
                        ->withInput();
        }

        SoftwareLicense::create(\$request->all());

        return redirect()->route('software_licenses.index')->with('success', 'Software license created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SoftwareLicense \$software_license)
    {
        \$software_license->load('vendor');
        return view('software_licenses.show', compact('software_license'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SoftwareLicense \$software_license)
    {
        \$vendors = Vendor::all();
        return view('software_licenses.edit', compact('software_license', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, SoftwareLicense \$software_license)
    {
        \$validator = Validator::make(\$request->all(), [
            'software_name' => 'required|string|max:255',
            'version' => 'nullable|string|max:100',
            'license_key' => 'nullable|string|max:255|unique:software_licenses,license_key,' . \$software_license->id,
            'number_of_licenses' => 'nullable|integer|min:0',
            'activation_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after_or_equal:activation_date',
            'vendor_id' => 'nullable|exists:vendors,id',
            'support_contact_info' => 'nullable|string|max:255',
            'linked_office_location' => 'nullable|string|max:255',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('software_licenses.edit', \$software_license->id)
                        ->withErrors(\$validator)
                        ->withInput();
        }

        \$software_license->update(\$request->all());

        return redirect()->route('software_licenses.index')->with('success', 'Software license updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SoftwareLicense \$software_license)
    {
        // Consider if there are related items (e.g., assets using this license)
        // that need to be handled before deletion.
        \$software_license->delete();
        return redirect()->route('software_licenses.index')->with('success', 'Software license deleted successfully.');
    }
}
