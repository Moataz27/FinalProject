@extends('layout')

@section('title', 'Register')

@section('content')
    <h2>Register Now!</h2>

    @include('error')

    <form action="{{ route('auth.register') }}" method="post">
        @csrf
        <label for="">Name</label>
        <br>
        <input type="text" name="name">
        <br>
        <label for="">Email</label>
        <br>
        <input type="email" name="email">
        <br>
        <label for="">Password</label>
        <br>
        <input type="password" name="password">
        <br>
        <label for="">Password Confirmation</label>
        <br>
        <input type="password" name="password_confirmation">
        <br>
        <button type="submit" class="btn btn-primary mt-3">Register</button>
        
    </form>
@endsection