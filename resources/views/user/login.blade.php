@extends('layouts.guest')
@section('title', 'Login')
@section('content')

<div>
    <h1>Login</h1>
    @if(session('error'))
        <div>{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('user.login') }}">
        @csrf
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            @error('username')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="{{ route('user.register') }}">Register here</a></p>
</div>
@endsection