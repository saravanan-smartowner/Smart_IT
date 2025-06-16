<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Asset; // For linking assets in purchase items
use App\Models\PurchaseItem; // For creating purchase items
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // For database transactions

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Admin'); // Example: only Admin can manage purchases
        // Or $this->middleware('role:IT Manager'); based on your RBAC
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::with('vendor')->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::all();
        $assets = Asset::whereDoesntHave('purchaseItems')->whereIn('status', ['In Stock', 'New'])->get(); // Example: Show unassigned/new assets
        return view('purchases.create', compact('vendors', 'assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required|string|max:255|unique:purchases,invoice_number',
            'purchase_date' => 'required|date',
            'vendor_id' => 'required|exists:vendors,id',
            'linked_office_location' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.asset_id' => 'required_with:items|exists:assets,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.unit_cost' => 'required_with:items|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('purchases.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        DB::beginTransaction();
        try {
            $purchase = Purchase::create($request->only([
                'invoice_number',
                'purchase_date',
                'vendor_id',
                'linked_office_location'
            ]));

            if ($request->has('items')) {
                foreach ($request->items as $itemData) {
                    // Ensure asset_id is present and valid
                    if (!isset($itemData['asset_id']) || !isset($itemData['quantity']) || !isset($itemData['unit_cost'])) continue;

                    $purchase->purchaseItems()->create([
                        'asset_id' => $itemData['asset_id'],
                        'quantity' => $itemData['quantity'],
                        'unit_cost' => $itemData['unit_cost'],
                        'total_cost' => $itemData['quantity'] * $itemData['unit_cost'],
                        // You might also set warranty/AMC details here if they come from this form
                    ]);
                    // Optionally, update asset status or details here
                    // Asset::find($itemData['asset_id'])->update(['status' => 'In Stock', 'purchase_cost' => $itemData['unit_cost']]);
                }
            }

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error: Log::error($e->getMessage());
            return redirect()->route('purchases.create')
                        ->with('error', 'Error creating purchase: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['vendor', 'purchaseItems.asset']);
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $vendors = Vendor::all();
        $assets = Asset::whereIn('status', ['In Stock', 'New'])->orWhereHas('purchaseItems', function($query) use ($purchase) {
            $query->where('purchase_id', $purchase->id);
        })->get(); // Assets currently in stock OR already part of this purchase

        $purchase->load('purchaseItems'); // Make sure items are loaded for the edit form
        return view('purchases.edit', compact('purchase', 'vendors', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required|string|max:255|unique:purchases,invoice_number,' . $purchase->id,
            'purchase_date' => 'required|date',
            'vendor_id' => 'required|exists:vendors,id',
            'linked_office_location' => 'nullable|string|max:255',
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:purchase_items,id', // For existing items
            'items.*.asset_id' => 'required_with:items|exists:assets,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.unit_cost' => 'required_with:items|numeric|min:0',
            'items.*._destroy' => 'nullable|boolean', // For marking items for deletion
        ]);

        if ($validator->fails()) {
            return redirect()->route('purchases.edit', $purchase->id)
                        ->withErrors($validator)
                        ->withInput();
        }

        DB::beginTransaction();
        try {
            $purchase->update($request->only([
                'invoice_number',
                'purchase_date',
                'vendor_id',
                'linked_office_location'
            ]));

            if ($request->has('items')) {
                $existingItemIds = [];
                foreach ($request->items as $itemData) {
                    if (!isset($itemData['asset_id']) || !isset($itemData['quantity']) || !isset($itemData['unit_cost'])) continue;

                    if (isset($itemData['_destroy']) && $itemData['_destroy'] == '1' && isset($itemData['id'])) {
                        PurchaseItem::find($itemData['id'])->delete();
                        continue;
                    }

                    $item = $purchase->purchaseItems()->updateOrCreate(
                        ['id' => $itemData['id'] ?? null], // Use existing ID or null for new item
                        [
                            'asset_id' => $itemData['asset_id'],
                            'quantity' => $itemData['quantity'],
                            'unit_cost' => $itemData['unit_cost'],
                            'total_cost' => $itemData['quantity'] * $itemData['unit_cost'],
                        ]
                    );
                    $existingItemIds[] = $item->id;
                }
                // Remove items not present in the submission (unless you handle this differently)
                // $purchase->purchaseItems()->whereNotIn('id', $existingItemIds)->delete();
            }

            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            return redirect()->route('purchases.edit', $purchase->id)
                        ->with('error', 'Error updating purchase: ' . $e->getMessage())
                        ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            $purchase->purchaseItems()->delete(); // Delete related items first
            $purchase->delete();
            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Purchase and associated items deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            return redirect()->route('purchases.index')->with('error', 'Error deleting purchase: ' . $e->getMessage());
        }
    }
}
