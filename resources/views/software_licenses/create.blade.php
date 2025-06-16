@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Software License</h1>

    @if (\$errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach (\$errors->all() as \$error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('software_licenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="software_name">Software Name</label>
            <input type="text" class="form-control" id="software_name" name="software_name" value="{{ old('software_name') }}" required>
        </div>

        <div class="form-group">
            <label for="version">Version</label>
            <input type="text" class="form-control" id="version" name="version" value="{{ old('version') }}">
        </div>

        <div class="form-group">
            <label for="license_key">License Key / Subscription ID</label>
            <input type="text" class="form-control" id="license_key" name="license_key" value="{{ old('license_key') }}">
        </div>

        <div class="form-group">
            <label for="number_of_licenses">Number of Licenses/Users (0 for unlimited)</label>
            <input type="number" class="form-control" id="number_of_licenses" name="number_of_licenses" value="{{ old('number_of_licenses', 1) }}" min="0">
        </div>

        <div class="form-group">
            <label for="activation_date">Activation Date</label>
            <input type="date" class="form-control" id="activation_date" name="activation_date" value="{{ old('activation_date') }}">
        </div>

        <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
        </div>

        <div class="form-group">
            <label for="vendor_id">Vendor</label>
            <select class="form-control" id="vendor_id" name="vendor_id">
                <option value="">Select Vendor (if applicable)</option>
                @foreach (\$vendors as \$vendor)
                    <option value="{{ \$vendor->id }}" {{ old('vendor_id') == \$vendor->id ? 'selected' : '' }}>{{ \$vendor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="support_contact_info">Support Contact Info</label>
            <input type="text" class="form-control" id="support_contact_info" name="support_contact_info" value="{{ old('support_contact_info') }}">
        </div>

        <div class="form-group">
            <label for="linked_office_location">Linked Office Location</label>
            <input type="text" class="form-control" id="linked_office_location" name="linked_office_location" value="{{ old('linked_office_location') }}">
        </div>

        <button type="submit" class="btn btn-primary">Save License</button>
        <a href="{{ route('software_licenses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
