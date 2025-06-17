<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use App\Models\Asset; // For linking to assets
use App\Models\SoftwareLicense; // For linking to software licenses
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CredentialController extends Controller
{
    public function __construct()
    {
        \$this->middleware('auth');
        // IMPORTANT: Access to credentials should be highly restricted
        \$this->middleware('role:Admin'); // Example: Only Admin can manage all credentials
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Select only non-sensitive fields for the list view
        \$credentials = Credential::select('id', 'name', 'url', 'ip_address', 'username', 'asset_id', 'software_license_id')
                                ->with(['asset:id,name', 'softwareLicense:id,software_name']) // Eager load names
                                ->latest()->get();
        return view('credentials.index', compact('credentials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \$assets = Asset::select('id', 'name', 'serial_number')->get();
        \$software_licenses = SoftwareLicense::select('id', 'software_name', 'version')->get();
        return view('credentials.create', compact('assets', 'software_licenses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request)
    {
        \$validator = Validator::make(\$request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'ip_address' => 'nullable|string|max:255', // Consider IP validation: 'nullable|ip'
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'notes_configurations' => 'nullable|string',
            'asset_id' => 'nullable|exists:assets,id',
            'software_license_id' => 'nullable|exists:software_licenses,id',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('credentials.create')
                        ->withErrors(\$validator)
                        ->withInput();
        }

        // Password will be encrypted by the mutator in the Credential model
        Credential::create(\$request->all());

        return redirect()->route('credentials.index')->with('success', 'Credential saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Credential \$credential)
    {
        \$credential->load(['asset:id,name', 'softwareLicense:id,software_name']);
        return view('credentials.show', compact('credential'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Credential \$credential)
    {
        \$assets = Asset::select('id', 'name', 'serial_number')->get();
        \$software_licenses = SoftwareLicense::select('id', 'software_name', 'version')->get();
        return view('credentials.edit', compact('credential', 'assets', 'software_licenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, Credential \$credential)
    {
        \$validator = Validator::make(\$request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'nullable|url|max:255',
            'ip_address' => 'nullable|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed', // Allow password to be empty
            'notes_configurations' => 'nullable|string',
            'asset_id' => 'nullable|exists:assets,id',
            'software_license_id' => 'nullable|exists:software_licenses,id',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('credentials.edit', \$credential->id)
                        ->withErrors(\$validator)
                        ->withInput();
        }

        \$dataToUpdate = \$request->except('password');

        if (\$request->filled('password')) {
            \$dataToUpdate['password'] = \$request->password;
        }

        \$credential->update(\$dataToUpdate);

        return redirect()->route('credentials.index')->with('success', 'Credential updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credential \$credential)
    {
        \$credential->delete();
        return redirect()->route('credentials.index')->with('success', 'Credential deleted successfully.');
    }
}
