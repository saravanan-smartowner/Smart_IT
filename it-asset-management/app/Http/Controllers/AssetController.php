<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\User; // For assigned_to dropdown
use App\Models\Vendor; // For vendor_id dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // For status enum type validation

class AssetController extends Controller
{
    public function __construct()
    {
        \$this->middleware('auth');
        \$this->middleware('role:Admin')->except(['index', 'show']);
        \$this->middleware('role:IT Manager')->only(['index', 'show', 'create', 'store', 'edit', 'update']);
        \$this->middleware('role:Auditor')->only(['index', 'show']);
        \$this->middleware('role:General Staff')->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        \$assets = Asset::with(['assignedToUser', 'vendor'])->get(); // Eager load relationships
        return view('assets.index', ['assets' => \$assets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \$users = User::all(); // For 'assigned_to' dropdown
        \$vendors = Vendor::all(); // For 'vendor_id' dropdown
        // Define status options - these should match your application's defined statuses
        \$statusOptions = ['In Use', 'In Stock', 'Under Repair', 'Retired'];
        return view('assets.create', compact('users', 'vendors', 'statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request)
    {
        \$statusOptions = ['In Use', 'In Stock', 'Under Repair', 'Retired'];
        \$validator = Validator::make(\$request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'asset_type' => 'required|string|max:255', // Or use Rule::in if you have predefined types
            'serial_number' => 'required|string|max:255|unique:assets,serial_number',
            'model_number' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(\$statusOptions)],
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'notes' => 'nullable|string',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('assets.create')
                        ->withErrors(\$validator)
                        ->withInput();
        }

        Asset::create(\$request->all());
        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset \$asset)
    {
        \$asset->load(['assignedToUser', 'vendor']); // Eager load relationships
        return view('assets.show', ['asset' => \$asset]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset \$asset)
    {
        \$users = User::all();
        \$vendors = Vendor::all();
        \$statusOptions = ['In Use', 'In Stock', 'Under Repair', 'Retired'];
        return view('assets.edit', compact('asset', 'users', 'vendors', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, Asset \$asset)
    {
        \$statusOptions = ['In Use', 'In Stock', 'Under Repair', 'Retired'];
        \$validator = Validator::make(\$request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'asset_type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:assets,serial_number,' . \$asset->id,
            'model_number' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(\$statusOptions)],
            'location' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'notes' => 'nullable|string',
        ]);

        if (\$validator->fails()) {
            return redirect()->route('assets.edit', \$asset->id)
                        ->withErrors(\$validator)
                        ->withInput();
        }

        \$asset->update(\$request->all());
        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset \$asset)
    {
        \$asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }
}
