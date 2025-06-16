<!DOCTYPE html>
<html>
<head>
    <title>Software Licenses</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .actions a { margin-right: 5px; text-decoration: none; }
        .create-btn { display: inline-block; margin-bottom: 15px; padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;}
    </style>
</head>
<body>
    <h1>Software Licenses List</h1>
    <a href="{{ route('software-licenses.create') }}" class="create-btn">Create New Software License</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Software Name</th>
                <th>License Key</th>
                <th>Purchase Date</th>
                <th>Expiry Date</th>
                <th>Total Seats</th>
                <th>Available Seats</th>
                <th>Vendor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($software_licenses as $license)
                <tr>
                    <td>{{ $license->id }}</td>
                    <td>{{ $license->software_name }}</td>
                    <td>{{ $license->license_key }}</td>
                    <td>{{ $license->purchase_date ? $license->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $license->expiry_date ? $license->expiry_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $license->total_seats }}</td>
                    <td>{{ $license->available_seats }}</td>
                    <td>{{ $license->vendor ? $license->vendor->name : 'N/A' }}</td>
                    <td class="actions">
                        <a href="{{ route('software-licenses.show', $license->id) }}">View</a>
                        <a href="{{ route('software-licenses.edit', $license->id) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No software licenses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
