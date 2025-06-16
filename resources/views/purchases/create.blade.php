<!DOCTYPE html>
<html>
<head>
    <title>Create Purchase</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="date"], input[type="number"], textarea, select {
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
        }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Create New Purchase</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" required>
        </div>

        <div class="form-group">
            <label for="vendor_id">Vendor:</label>
            {{-- Assuming $vendors is passed from the controller --}}
            <select id="vendor_id" name="vendor_id" required>
                <option value="">Select Vendor</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="total_cost">Total Cost:</label>
            <input type="number" id="total_cost" name="total_cost" step="0.01" value="{{ old('total_cost') }}" required>
        </div>
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        <button type="submit">Create Purchase</button>
    </form>
</body>
</html>
