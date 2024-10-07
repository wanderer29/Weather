@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center">
    <h1 class="m-3">Welcome</h1>
    <a href="{{ route('user.login') }}" class="btn btn-primary me-2">Login</a>
    <a href="{{ route('user.register') }}" class="btn btn-secondary">Register</a>
</div>
@endsection
