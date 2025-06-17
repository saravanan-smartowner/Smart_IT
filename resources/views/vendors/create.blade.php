@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Vendor</h1>

    @if (\$errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach (\$errors->all() as \$error)
                    <li>{{ \$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vendors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Vendor Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
        </div>

        <div class="form-group">
            <label for="contact_person">Contact Person</label>
            <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="products_services_supplied">Products/Services Supplied</label>
            <textarea class="form-control" id="products_services_supplied" name="products_services_supplied" rows="3">{{ old('products_services_supplied') }}</textarea>
        </div>

        <div class="form-group">
            <label for="sla_terms">SLA Terms</label>
            <textarea class="form-control" id="sla_terms" name="sla_terms" rows="3">{{ old('sla_terms') }}</textarea>
        </div>

        <div class="form-group">
            <label for="escalation_matrix">Escalation Matrix</label>
            <textarea class="form-control" id="escalation_matrix" name="escalation_matrix" rows="3">{{ old('escalation_matrix') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Vendor</button>
        <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
