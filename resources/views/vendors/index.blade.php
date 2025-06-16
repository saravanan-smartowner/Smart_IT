<!DOCTYPE html>
<html>
<head>
    <title>Vendors</title>
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
    <h1>Vendors List</h1>
    <a href="{{ route('vendors.create') }}" class="create-btn">Create New Vendor</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->id }}</td>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ $vendor->contact_person ?? 'N/A' }}</td>
                    <td>{{ $vendor->email ?? 'N/A' }}</td>
                    <td>{{ $vendor->phone ?? 'N/A' }}</td>
                    <td class="actions">
                        <a href="{{ route('vendors.show', $vendor->id) }}">View</a>
                        <a href="{{ route('vendors.edit', $vendor->id) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No vendors found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
