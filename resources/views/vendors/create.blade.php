<!DOCTYPE html>
<html>
<head>
    <title>Create Vendor</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"], textarea {
            width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;
        }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Create New Vendor</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vendors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="contact_person">Contact Person:</label>
            <input type="text" id="contact_person" name="contact_person" value="{{ old('contact_person') }}">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address">{{ old('address') }}</textarea>
        </div>
        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
        </div>
        <button type="submit">Create Vendor</button>
    </form>
</body>
</html>
