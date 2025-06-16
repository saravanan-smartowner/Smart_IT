<!DOCTYPE html>
<html>
<head>
    <title>Purchases</title>
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
    <h1>Purchases List</h1>
    <a href="{{ route('purchases.create') }}" class="create-btn">Create New Purchase</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Purchase Date</th>
                <th>Vendor</th>
                <th>Total Cost</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ $purchase->vendor ? $purchase->vendor->name : 'N/A' }}</td>
                    <td>{{ $purchase->total_cost }}</td>
                    <td>{{ $purchase->notes ?? 'N/A' }}</td>
                    <td class="actions">
                        <a href="{{ route('purchases.show', $purchase->id) }}">View</a>
                        <a href="{{ route('purchases.edit', $purchase->id) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No purchases found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
