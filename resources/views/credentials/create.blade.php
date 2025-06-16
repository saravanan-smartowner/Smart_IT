<!DOCTYPE html>
<html>
<head>
    <title>Create Credential</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"], input[type="number"], textarea, select {
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
        }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Create New Credential</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('credentials.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="credential_type">Credential Type:</label>
            <input type="text" id="credential_type" name="credential_type" value="{{ old('credential_type') }}" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="asset_id">Related Asset (optional):</label>
            {{-- Assuming $assets is passed from the controller --}}
            <select id="asset_id" name="asset_id">
                <option value="">None</option>
                @foreach ($assets as $asset)
                    <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>{{ $asset->name }} (ID: {{ $asset->id }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="software_license_id">Related Software License (optional):</label>
            {{-- Assuming $software_licenses is passed from the controller --}}
            <select id="software_license_id" name="software_license_id">
                <option value="">None</option>
                @foreach ($software_licenses as $license)
                    <option value="{{ $license->id }}" {{ old('software_license_id') == $license->id ? 'selected' : '' }}>{{ $license->software_name }} (ID: {{ $license->id }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        <button type="submit">Create Credential</button>
    </form>
</body>
</html>
