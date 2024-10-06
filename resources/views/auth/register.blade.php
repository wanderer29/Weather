@extends('layouts.app')

@section('title', 'Registration')

@section('header_title', 'Registration')

@section('content')
    <div class="row justify-content-center">
        <div class="card col-md-6">
            <div class="card-header">
                <h2>Create an Account</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('user.register') }}" method="POST" onsubmit="return checkPasswords()">
                    @csrf

                    <div class="mb-3">
                        <label for="login" class="form-label">Login:</label>
                        <input type="text" class="form-control" id="login" name="login" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password:</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirm_password">Confirm password:</label>
                        <input class="form-control" type="password" id="password_confirmation"
                               name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-link">Login</a>
                    <a href="{{ route('welcome') }}" class="btn btn-secondary">Back to Home</a>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger m-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/register.js' )}}"
@endpush
