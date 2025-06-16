<!DOCTYPE html>
<html>
<head>
    <title>Credentials</title>
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
    <h1>Credentials List</h1>
    <a href="{{ route('credentials.create') }}" class="create-btn">Create New Credential</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Username</th>
                <th>Asset</th>
                <th>Software License</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($credentials as $credential)
                <tr>
                    <td>{{ $credential->id }}</td>
                    <td>{{ $credential->credential_type }}</td>
                    <td>{{ $credential->username }}</td>
                    <td>{{ $credential->asset ? $credential->asset->name : 'N/A' }}</td>
                    <td>{{ $credential->softwareLicense ? $credential->softwareLicense->software_name : 'N/A' }}</td>
                    <td>{{ $credential->notes ?? 'N/A' }}</td>
                    <td class="actions">
                        <a href="{{ route('credentials.show', $credential->id) }}">View</a>
                        <a href="{{ route('credentials.edit', $credential->id) }}">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No credentials found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
