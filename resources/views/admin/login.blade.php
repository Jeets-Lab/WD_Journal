@extends('layouts.guest')
@section('title', 'Admin Login')
@section('content')

<div>
    <h1>Admin Login</h1>
    @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
    @endif
    @if ($errors->any())
            <ul style="color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    @endif
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>

@endsection