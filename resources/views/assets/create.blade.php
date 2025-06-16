<!DOCTYPE html>
<html>
<head>
    <title>Create Asset</title>
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
    <h1>Create New Asset</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assets.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="asset_type">Asset Type:</label>
            <input type="text" id="asset_type" name="asset_type" value="{{ old('asset_type') }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="serial_number">Serial Number:</label>
            <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
        </div>
        <div class="form-group">
            <label for="purchase_date">Purchase Date:</label>
            <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
        </div>
        <div class="form-group">
            <label for="purchase_cost">Purchase Cost:</label>
            <input type="number" id="purchase_cost" name="purchase_cost" step="0.01" value="{{ old('purchase_cost') }}">
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="{{ old('status') }}" required>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="{{ old('location') }}">
        </div>
        {{-- Assuming you'll pass $users and $vendors to the view from the controller's create method --}}
        {{-- <div class="form-group">
            <label for="assigned_to">Assigned To (User ID):</label>
            <select id="assigned_to" name="assigned_to">
                <option value="">Unassigned</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="vendor_id">Vendor ID:</label>
             <select id="vendor_id" name="vendor_id">
                <option value="">None</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div> --}}
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        <button type="submit">Create Asset</button>
    </form>
</body>
</html>
