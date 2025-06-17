@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Secure Credential</h1>

    @if (\$errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach (\$errors->all() as \$error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('credentials.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name / System Identifier</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            <small class="form-text text-muted">E.g., "Primary Database Server", "Router Admin Panel"</small>
        </div>

        <div class="form-group">
            <label for="url">URL (if applicable)</label>
            <input type="url" class="form-control" id="url" name="url" value="{{ old('url') }}" placeholder="https://example.com/admin">
        </div>

        <div class="form-group">
            <label for="ip_address">IP Address & Port (if applicable)</label>
            <input type="text" class="form-control" id="ip_address" name="ip_address" value="{{ old('ip_address') }}" placeholder="e.g., 192.168.1.100 or 10.0.0.5:3306">
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="notes_configurations">Notes / Configurations</label>
            <textarea class="form-control" id="notes_configurations" name="notes_configurations" rows="4">{{ old('notes_configurations') }}</textarea>
            <small class="form-text text-muted">Any additional notes, API keys, configuration snippets, etc.</small>
        </div>

        <div class="form-group">
            <label for="asset_id">Link to Asset (Optional)</label>
            <select class="form-control" id="asset_id" name="asset_id">
                <option value="">None</option>
                @foreach (\$assets as \$asset)
                    <option value="{{ \$asset->id }}" {{ old('asset_id') == \$asset->id ? 'selected' : '' }}>{{ \$asset->name }} ({{ \$asset->serial_number ?? 'N/A' }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="software_license_id">Link to Software License (Optional)</label>
            <select class="form-control" id="software_license_id" name="software_license_id">
                <option value="">None</option>
                @foreach (\$software_licenses as \$license)
                    <option value="{{ \$license->id }}" {{ old('software_license_id') == \$license->id ? 'selected' : '' }}>{{ \$license->software_name }} {{ \$license->version ?? '' }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Credential</button>
        <a href="{{ route('credentials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
