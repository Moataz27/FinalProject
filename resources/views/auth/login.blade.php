@extends('layout')

@section('title', 'Login')

@section('content')
    <h2>Login!</h2>

    @include('error')

    @if (request()->session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ request()->session()->get('error') }}
        </div>
    @endif
    <form action="{{ route('auth.login') }}" method="post">
        @csrf
        <label for="">Email</label>
        <br>
        <input type="email" name="email">
        <br>
        <label for="">Password</label>
        <br>
        <input type="password" name="password">
        <br>
        <button type="submit" class="btn btn-primary mt-3">Login</button>
        
    </form>
@endsection