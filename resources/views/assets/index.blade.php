<!DOCTYPE html>
<html>
<head>
    <title>Assets</title>
    <!-- Basic styling -->
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
    <h1>Assets List</h1>
    <a href="{{ route('assets.create') }}" class="create-btn">Create New Asset</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Asset Type</th>
                <th>Status</th>
                <th>Serial Number</th>
                <th>Purchase Date</th>
                <th>Purchase Cost</th>
                <th>Location</th>
                <th>Assigned To</th>
                <th>Vendor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assets as $asset)
                <tr>
                    <td>{{ $asset->id }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->asset_type }}</td>
                    <td>{{ $asset->status }}</td>
                    <td>{{ $asset->serial_number ?? 'N/A' }}</td>
                    <td>{{ $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $asset->purchase_cost ?? 'N/A' }}</td>
                    <td>{{ $asset->location ?? 'N/A' }}</td>
                    <td>{{ $asset->assignedToUser ? $asset->assignedToUser->name : 'Unassigned' }}</td>
                    <td>{{ $asset->vendor ? $asset->vendor->name : 'N/A' }}</td>
                    <td class="actions">
                        <a href="{{ route('assets.show', $asset->id) }}">View</a>
                        <a href="{{ route('assets.edit', $asset->id) }}">Edit</a>
                        {{-- Add delete form if needed --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11">No assets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
