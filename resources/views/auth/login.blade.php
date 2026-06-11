@extends('layouts.app')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="card">
            <div class="auth-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="login">Username or Email</label>
                    <input type="text" id="login" name="login" value="{{ old('login') }}" required autofocus autocomplete="username">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" style="font-weight:400;font-size:0.875rem;">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;">Sign In</button>
            </form>

            <div class="auth-footer">
                <a href="{{ route('password.request') }}">Forgot your password?</a>
                <br>
                Don't have an account? <a href="{{ route('register') }}">Register</a>
            </div>
        </div>
    </div>
</div>
@endsection