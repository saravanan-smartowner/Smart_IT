@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<div class="container">
    <h1>Edit Asset: {{ \$asset->name }}</h1>

    @if (\$errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach (\$errors->all() as \$error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assets.update', \$asset->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Asset Name/Identifier</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', \$asset->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', \$asset->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="asset_type">Asset Type (e.g., Laptop, Monitor)</label>
            <input type="text" class="form-control" id="asset_type" name="asset_type" value="{{ old('asset_type', \$asset->asset_type) }}" required>
        </div>

        <div class="form-group">
            <label for="serial_number">Serial Number</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ old('serial_number', \$asset->serial_number) }}" required>
        </div>

        <div class="form-group">
            <label for="model_number">Model Number</label>
            <input type="text" class="form-control" id="model_number" name="model_number" value="{{ old('model_number', \$asset->model_number) }}" required>
        </div>

        <div class="form-group">
            <label for="category">Category (e.g., IT, Electronics)</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ old('category', \$asset->category) }}" required>
        </div>

        <div class="form-group">
            <label for="purchase_date">Purchase Date</label>
            <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', \$asset->purchase_date ? \$asset->purchase_date->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
            <label for="purchase_cost">Purchase Cost</label>
            <input type="number" step="0.01" class="form-control" id="purchase_cost" name="purchase_cost" value="{{ old('purchase_cost', \$asset->purchase_cost) }}">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="">Select Status</option>
                @foreach (\$statusOptions as \$option)
                    <option value="{{ \$option }}" {{ old('status', \$asset->status) == \$option ? 'selected' : '' }}>{{ \$option }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', \$asset->location) }}">
        </div>

        <div class="form-group">
            <label for="assigned_to">Assigned To (User)</label>
            <select class="form-control" id="assigned_to" name="assigned_to">
                <option value="">None</option>
                @foreach (\$users as \$user)
                    <option value="{{ \$user->id }}" {{ old('assigned_to', \$asset->assigned_to) == \$user->id ? 'selected' : '' }}>{{ \$user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="vendor_id">Vendor</label>
            <select class="form-control" id="vendor_id" name="vendor_id">
                <option value="">None</option>
                @foreach (\$vendors as \$vendor)
                    <option value="{{ \$vendor->id }}" {{ old('vendor_id', \$asset->vendor_id) == \$vendor->id ? 'selected' : '' }}>{{ \$vendor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea class="form-control" id="notes" name="notes">{{ old('notes', \$asset->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Asset</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
