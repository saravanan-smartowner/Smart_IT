<!DOCTYPE html>
<html>
<head>
    <title>Show Asset: {{ $asset->name }}</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .property { margin-bottom: 10px; }
        .property strong { display: inline-block; width: 150px; }
        .actions a { margin-right: 10px; text-decoration: none; padding: 8px 12px; border-radius: 4px; }
        .edit-btn { background-color: #ffc107; color: black; }
        .back-btn { background-color: #6c757d; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Asset Details: {{ $asset->name }}</h1>

        <div class="property">
            <strong>ID:</strong> {{ $asset->id }}
        </div>
        <div class="property">
            <strong>Name:</strong> {{ $asset->name }}
        </div>
        <div class="property">
            <strong>Asset Type:</strong> {{ $asset->asset_type }}
        </div>
        <div class="property">
            <strong>Description:</strong> {{ $asset->description ?? 'N/A' }}
        </div>
        <div class="property">
            <strong>Serial Number:</strong> {{ $asset->serial_number ?? 'N/A' }}
        </div>
        <div class="property">
            <strong>Purchase Date:</strong> {{ $asset->purchase_date ? $asset->purchase_date->format('Y-m-d') : 'N/A' }}
        </div>
        <div class="property">
            <strong>Purchase Cost:</strong> {{ $asset->purchase_cost ?? 'N/A' }}
        </div>
        <div class="property">
            <strong>Status:</strong> {{ $asset->status }}
        </div>
        <div class="property">
            <strong>Location:</strong> {{ $asset->location ?? 'N/A' }}
        </div>
        <div class="property">
            <strong>Assigned To:</strong> {{ $asset->assignedToUser ? $asset->assignedToUser->name : 'Unassigned' }}
        </div>
        <div class="property">
            <strong>Vendor:</strong> {{ $asset->vendor ? $asset->vendor->name : 'N/A' }}
        </div>
        <div class="property">
            <strong>Notes:</strong> {{ $asset->notes ?? 'N/A' }}
        </div>
        <div class="property">
            <strong>Created At:</strong> {{ $asset->created_at ? $asset->created_at->format('Y-m-d H:i:s') : 'N/A' }}
        </div>
        <div class="property">
            <strong>Updated At:</strong> {{ $asset->updated_at ? $asset->updated_at->format('Y-m-d H:i:s') : 'N/A' }}
        </div>

        <div class="actions" style="margin-top: 20px;">
            <a href="{{ route('assets.edit', $asset->id) }}" class="edit-btn">Edit</a>
            <a href="{{ route('assets.index') }}" class="back-btn">Back to List</a>
        </div>
    </div>
</body>
</html>
