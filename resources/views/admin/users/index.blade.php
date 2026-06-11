@extends('layouts.dashboard')

@section('title', 'Manage Users - Admin')

@section('content')
<div class="page-header flex-between-wrap">
    <div>
        <h1>User Management</h1>
        <p>Manage all registered users</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">+ Add User</a>
</div>

<form method="GET" action="{{ route('admin.users.index') }}" class="search-bar">
    <input type="text" name="search" placeholder="Search by name, username, or email..." value="{{ request('search') }}">
    <button type="submit" class="btn btn-secondary">Search</button>
    @if(request('search'))
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Clear</a>
    @endif
</form>

<div class="card card--no-pad">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role && $user->role->slug === 'administrator')
                            <span class="badge badge-admin">Administrator</span>
                        @else
                            <span class="badge badge-user">{{ $user->role_name }}</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty-table-cell">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $users->links() }}
@endsection