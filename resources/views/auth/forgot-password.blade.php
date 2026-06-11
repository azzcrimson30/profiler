@extends('layouts.app')

@section('title', 'Forgot Password - ' . config('app.name'))

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="card">
            <div class="auth-header">
                <h1>Reset Password</h1>
                <p>Enter your email to receive a reset link</p>
            </div>

            @if(session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">Send Reset Link</button>
            </form>

            <div class="auth-footer">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </div>
    </div>
</div>
@endsection