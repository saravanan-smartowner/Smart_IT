<!DOCTYPE html>
<html>
<head>
    <title>Edit Asset: {{ $asset->name }}</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="date"], input[type="number"], textarea, select {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
        }
        button { padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .back-link { display: inline-block; margin-top:15px; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Asset: {{ $asset->name }}</h1>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <strong>Whoops! Something went wrong.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $asset->name) }}" required>
            </div>

            <div class="form-group">
                <label for="asset_type">Asset Type:</label>
                <input type="text" id="asset_type" name="asset_type" value="{{ old('asset_type', $asset->asset_type) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description">{{ old('description', $asset->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="serial_number">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" value="{{ old('serial_number', $asset->serial_number) }}">
            </div>

            <div class="form-group">
                <label for="purchase_date">Purchase Date:</label>
                <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : '') }}">
            </div>

            <div class="form-group">
                <label for="purchase_cost">Purchase Cost:</label>
                <input type="number" id="purchase_cost" name="purchase_cost" step="0.01" value="{{ old('purchase_cost', $asset->purchase_cost) }}">
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" value="{{ old('status', $asset->status) }}" required>
            </div>

            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="{{ old('location', $asset->location) }}">
            </div>

            {{-- Assuming $users and $vendors are passed from the controller's edit method --}}
            {{-- <div class="form-group">
                <label for="assigned_to">Assigned To (User ID):</label>
                <select id="assigned_to" name="assigned_to">
                    <option value="">Unassigned</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to', $asset->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="vendor_id">Vendor:</label>
                <select id="vendor_id" name="vendor_id">
                    <option value="">None</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ old('vendor_id', $asset->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="form-group">
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes">{{ old('notes', $asset->notes) }}</textarea>
            </div>

            <button type="submit">Update Asset</button>
        </form>
        <a href="{{ route('assets.index') }}" class="back-link">Back to List</a>
    </div>
</body>
</html>
