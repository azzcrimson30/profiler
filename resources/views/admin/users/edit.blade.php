@extends('layouts.dashboard')

@section('title', 'Edit User - Admin')

@section('content')
<div class="page-header">
    <h1>Edit User</h1>
    <p>Update user information for <strong>{{ $user->name }}</strong></p>
</div>

<div class="card card--narrow">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="list-reset">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password <small class="small-muted">(leave blank to keep current)</small></label>
            <input type="password" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="avatar">Avatar</label>
            @if($user->avatar)
                <div class="d-flex gap-0.5 align-center mb-0.5">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="User avatar" style="width:64px;height:64px;object-fit:cover;border-radius:8px;">
                    <label class="small-muted"><input type="checkbox" name="avatar_remove" value="1"> Remove avatar</label>
                </div>
            @endif
            <input type="file" id="avatar" name="avatar" accept="image/*">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="form-group">
            <label for="role_id">Role *</label>
            <select id="role_id" name="role_id" required>
                <option value="">Select a role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-0.75">
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection