<!DOCTYPE html>
<html>
<head>
    <title>Create Software License</title>
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
    <h1>Create New Software License</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('software-licenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="software_name">Software Name:</label>
            <input type="text" id="software_name" name="software_name" value="{{ old('software_name') }}" required>
        </div>
        <div class="form-group">
            <label for="license_key">License Key:</label>
            <input type="text" id="license_key" name="license_key" value="{{ old('license_key') }}" required>
        </div>
        <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" required>
        </div>
        <div class="form-group">
            <label for="expiry_date">Expiry Date (optional):</label>
            <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
        </div>
        <div class="form-group">
            <label for="purchase_cost">Purchase Cost:</label>
            <input type="number" id="purchase_cost" name="purchase_cost" step="0.01" value="{{ old('purchase_cost') }}" required>
        </div>
        <div class="form-group">
            <label for="total_seats">Total Seats:</label>
            <input type="number" id="total_seats" name="total_seats" value="{{ old('total_seats') }}" required>
        </div>
         <div class="form-group">
            <label for="available_seats">Available Seats:</label>
            <input type="number" id="available_seats" name="available_seats" value="{{ old('available_seats') }}" required>
        </div>
        <div class="form-group">
            <label for="vendor_id">Vendor:</label>
            {{-- Assuming $vendors is passed from the controller --}}
            <select id="vendor_id" name="vendor_id">
                <option value="">Select Vendor</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        <button type="submit">Create Software License</button>
    </form>
</body>
</html>
