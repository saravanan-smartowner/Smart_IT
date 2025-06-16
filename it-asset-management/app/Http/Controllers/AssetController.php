<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        \$assets = Asset::all();
        return view('assets.index', ['assets' => \$assets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request \$request)
    {
        \$validator = Validator::make(\$request->all(), [
            // Assuming 'name' is a general identifier for the asset
            'name' => 'required|string|max:255',
            'serial_number' => 'required|unique:assets,serial_number',
            'model_number' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            // Add other validation rules as per your asset fields in $fillable
            // e.g., 'purchase_date' => 'nullable|date', 'purchase_cost' => 'nullable|numeric', etc.
        ]);

        if (\$validator->fails()) {
            return redirect()->route('assets.create')
                        ->withErrors(\$validator)
                        ->withInput();
        }

        // Ensure your \$fillable in Asset.php includes all fields you intend to mass assign
        Asset::create(\$request->all());
        return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset \$asset)
    {
        return view('assets.show', ['asset' => \$asset]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset \$asset)
    {
        return view('assets.edit', ['asset' => \$asset]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request \$request, Asset \$asset)
    {
        \$validator = Validator::make(\$request->all(), [
            'name' => 'required|string|max:255',
            'serial_number' => 'required|unique:assets,serial_number,' . \$asset->id,
            'model_number' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            // Add other validation rules
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
