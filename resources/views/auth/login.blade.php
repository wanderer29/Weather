@extends('layouts.app')

@section('title', 'Authorization')

@section('header_title', 'Login')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-md-6">
            <div class="card-header">
                <h2>Login to Account</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('user.login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="login">Login:</label>
                        <input class="form-control" type="text" id="login" name="login" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password:</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                    </div>
                    <button class="btn btn-primary" type="submit">
                        Login
                    </button>
                    <a href="{{ route('register.index') }}" class="btn btn-link">Register</a>
                    <a href="{{ route('welcome') }}" class="btn btn-secondary">Back to Home</a>
                </form>
                @if (session('error'))
                    <div class="alert alert-danger m-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

