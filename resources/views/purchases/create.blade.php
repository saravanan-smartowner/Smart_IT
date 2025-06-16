@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Purchase</h1>

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

    <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="invoice_number">Invoice Number</label>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="purchase_date">Purchase Date</label>
                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
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
                            <option value="{{ \$vendor->id }}" {{ old('vendor_id') == \$vendor->id ? 'selected' : '' }}>{{ \$vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="linked_office_location">Linked Office/Location</label>
                    <input type="text" class="form-control" id="linked_office_location" name="linked_office_location" value="{{ old('linked_office_location') }}">
                </div>
            </div>
        </div>

        <hr>
        <h3>Purchase Items</h3>
        <div id="purchase-items-container">
            {{-- Item Row Template (for JavaScript) --}}
            <div class="row item-row" style="display: none;" id="item-template">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Asset</label>
                        <select class="form-control asset-select" name="items[__INDEX__][asset_id]">
                            <option value="">Select Asset</option>
                            @foreach (\$assets as \$asset)
                                <option value="{{ \$asset->id }}" data-name="{{ \$asset->name }}">{{ \$asset->name }} ({{ \$asset->serial_number ?? 'N/A' }})</option>
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
                <div class="col-md-3">
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
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-danger btn-sm remove-item-btn">X</button>
                </div>
            </div>

            {{-- Existing items from old input (if validation failed) --}}
            @if(old('items'))
                @foreach(old('items') as \$index => \$item)
                    <div class="row item-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Asset</label>
                                <select class="form-control asset-select" name="items[{{ \$index }}][asset_id]">
                                    <option value="">Select Asset</option>
                                    @foreach (\$assets as \$asset)
                                        <option value="{{ \$asset->id }}" {{ \$item['asset_id'] == \$asset->id ? 'selected' : '' }}>{{ \$asset->name }} ({{ \$asset->serial_number ?? 'N/A' }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control quantity-input" name="items[{{ \$index }}][quantity]" value="{{ \$item['quantity'] ?? 1 }}" min="1">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Unit Cost</label>
                                <input type="number" step="0.01" class="form-control unit-cost-input" name="items[{{ \$index }}][unit_cost]" value="{{ \$item['unit_cost'] ?? 0.00 }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Total Cost</label>
                                <input type="text" class="form-control total-cost-display" value="{{ number_format((\$item['quantity'] ?? 1) * (\$item['unit_cost'] ?? 0), 2) }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm remove-item-btn">X</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button type="button" class="btn btn-success" id="add-item-btn">Add Item</button>

        <hr>
        <button type="submit" class="btn btn-primary">Save Purchase</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
// Basic JavaScript for adding/removing items and calculating total cost.
// You'll likely want to enhance this or use a library like Vue/React for more complex forms.
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = {{ old('items') ? count(old('items')) : 0 }};
    const itemsContainer = document.getElementById('purchase-items-container');
    const template = document.getElementById('item-template');

    document.getElementById('add-item-btn').addEventListener('click', function () {
        const newItemRow = template.cloneNode(true);
        newItemRow.removeAttribute('id');
        newItemRow.removeAttribute('style'); // Make it visible
        newItemRow.innerHTML = newItemRow.innerHTML.replace(/__INDEX__/g, itemIndex);
        itemsContainer.appendChild(newItemRow);
        itemIndex++;
        attachEventListeners(newItemRow);
    });

    function attachEventListeners(row) {
        row.querySelector('.remove-item-btn').addEventListener('click', function() {
            row.remove();
        });

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

    // Attach listeners to already existing rows (e.g., from validation error)
    document.querySelectorAll('#purchase-items-container .item-row').forEach(row => {
        if (row.id !== 'item-template') { // Don't attach to the template itself
            attachEventListeners(row);
        }
    });
});
</script>
@endsection
