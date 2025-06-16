@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Purchase: {{ \$purchase->invoice_number }}</h1>

    @if (\$errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach (\$errors->all() as \$error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('purchases.update', \$purchase->id) }}" method="POST" id="purchase-form">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="invoice_number">Invoice Number</label>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', \$purchase->invoice_number) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="purchase_date">Purchase Date</label>
                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', \$purchase->purchase_date ? \$purchase->purchase_date->format('Y-m-d') : '') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="vendor_id">Vendor</label>
                    <select class="form-control" id="vendor_id" name="vendor_id" required>
                        <option value="">Select Vendor</option>
                        @foreach (\$vendors as \$vendor)
                            <option value="{{ \$vendor->id }}" {{ old('vendor_id', \$purchase->vendor_id) == \$vendor->id ? 'selected' : '' }}>{{ \$vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="linked_office_location">Linked Office/Location</label>
                    <input type="text" class="form-control" id="linked_office_location" name="linked_office_location" value="{{ old('linked_office_location', \$purchase->linked_office_location) }}">
                </div>
            </div>
        </div>

        <hr>
        <h3>Purchase Items</h3>
        <div id="purchase-items-container">
            {{-- Item Row Template (for JavaScript) --}}
            <div class="row item-row" style="display: none;" id="item-template">
                <input type="hidden" name="items[__INDEX__][id]" value=""> {{-- For existing items --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Asset</label>
                        <select class="form-control asset-select" name="items[__INDEX__][asset_id]">
                            <option value="">Select Asset</option>
                            @foreach (\$assets as \$asset)
                                <option value="{{ \$asset->id }}">{{ \$asset->name }} ({{ \$asset->serial_number ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control quantity-input" name="items[__INDEX__][quantity]" value="1" min="1">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Unit Cost</label>
                        <input type="number" step="0.01" class="form-control unit-cost-input" name="items[__INDEX__][unit_cost]" value="0.00" min="0">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Total Cost</label>
                        <input type="text" class="form-control total-cost-display" readonly>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-check" style="margin-top: 35px;">
                        <input class="form-check-input" type="checkbox" name="items[__INDEX__][_destroy]" value="1" id="destroy___INDEX__">
                        <label class="form-check-label" for="destroy___INDEX__">Del?</label>
                    </div>
                </div>
                 <div class="col-md-1">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm remove-item-btn">X</button> {{-- This button is for newly added rows only --}}
                </div>
            </div>

            {{-- Existing items from purchase or old input --}}
            @php \$item_idx = 0; @endphp
            @foreach (old('items', $purchase->purchaseItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'asset_id' => $item->asset_id,
                    'quantity' => $item->quantity,
                    'unit_cost' => $item->unit_cost,
                ];
            })->toArray()) as $index => $item_data)
            <div class="row item-row">
                <input type="hidden" name="items[{{ \$item_idx }}][id]" value="{{ \$item_data['id'] ?? '' }}">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Asset</label>
                        <select class="form-control asset-select" name="items[{{ \$item_idx }}][asset_id]">
                            <option value="">Select Asset</option>
                            @foreach (\$assets as \$asset)
                                <option value="{{ \$asset->id }}" {{ (\$item_data['asset_id'] ?? null) == \$asset->id ? 'selected' : '' }}>
                                    {{ \$asset->name }} ({{ \$asset->serial_number ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control quantity-input" name="items[{{ \$item_idx }}][quantity]" value="{{ \$item_data['quantity'] ?? 1 }}" min="1">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Unit Cost</label>
                        <input type="number" step="0.01" class="form-control unit-cost-input" name="items[{{ \$item_idx }}][unit_cost]" value="{{ number_format(\$item_data['unit_cost'] ?? 0.00, 2, '.', '') }}" min="0">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Total Cost</label>
                        <input type="text" class="form-control total-cost-display" value="{{ number_format((\$item_data['quantity'] ?? 1) * (\$item_data['unit_cost'] ?? 0), 2) }}" readonly>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-check" style="margin-top: 35px;">
                        <input class="form-check-input" type="checkbox" name="items[{{ \$item_idx }}][_destroy]" value="1" id="destroy_{{ \$item_idx }}">
                        <label class="form-check-label" for="destroy_{{ \$item_idx }}">Del?</label>
                    </div>
                </div>
                {{-- No remove button for existing persistent items, only _destroy checkbox --}}
            </div>
            @php \$item_idx++; @endphp
            @endforeach
        </div>
        <button type="button" class="btn btn-success mt-2" id="add-item-btn">Add Item</button>

        <hr>
        <button type="submit" class="btn btn-primary">Update Purchase</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = {{ \$item_idx }}; // Start index from count of existing items
    const itemsContainer = document.getElementById('purchase-items-container');
    const template = document.getElementById('item-template');

    document.getElementById('add-item-btn').addEventListener('click', function () {
        const newItemRow = template.cloneNode(true);
        newItemRow.removeAttribute('id');
        newItemRow.removeAttribute('style');
        newItemRow.innerHTML = newItemRow.innerHTML.replace(/__INDEX__/g, itemIndex).replace(/destroy___INDEX__/g, 'destroy_' + itemIndex);
        itemsContainer.appendChild(newItemRow);
        // For newly added rows, the remove button is functional, _destroy is not relevant yet.
        newItemRow.querySelector('.form-check').style.display = 'none'; // Hide delete checkbox for new rows initially
        attachEventListeners(newItemRow, true);
        itemIndex++;
    });

    function attachEventListeners(row, isNewRow) {
        if(isNewRow){
            // Only new rows (not persisted yet) get a direct remove button.
            // Persisted rows use the _destroy checkbox.
            const removeBtn = row.querySelector('.remove-item-btn');
            if(removeBtn) removeBtn.addEventListener('click', function() { row.remove(); });
        } else {
            // For existing rows, hide the 'X' remove button as they are handled by _destroy flag
            const removeBtn = row.querySelector('.remove-item-btn');
            if(removeBtn) removeBtn.style.display = 'none';
        }

        const quantityInput = row.querySelector('.quantity-input');
        const unitCostInput = row.querySelector('.unit-cost-input');
        const totalCostDisplay = row.querySelector('.total-cost-display');

        function updateTotal() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const unitCost = parseFloat(unitCostInput.value) || 0;
            totalCostDisplay.value = (quantity * unitCost).toFixed(2);
        }

        quantityInput.addEventListener('input', updateTotal);
        unitCostInput.addEventListener('input', updateTotal);
        updateTotal(); // Initial calculation
    }

    document.querySelectorAll('#purchase-items-container .item-row').forEach(row => {
        if (row.id !== 'item-template') {
            attachEventListeners(row, false); // false for existing rows on page load
        }
    });
});
</script>
@endsection
