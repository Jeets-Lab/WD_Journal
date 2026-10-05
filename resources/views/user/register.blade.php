@extends('layouts.guest')
@section('title', 'Register')
@section('content')

<div>
    <h1>Create Account</h1>
    <p>Join our Social Network</p>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div>
            <ul style="color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
        </div>

        <div>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="{{ old('city') }}" required>
        </div>

        <div>
            <label for="profile_image">Profile Image (optional)</label>
            <input type="file" id="profile_image" name="profile_image">
        </div>

        <!-- Captcha -->
        <div>
            <label for="captcha">Captcha</label>
            <p>What is <strong>{{ $num1 }} + {{ $num2 }}?</strong></p>
            <input type="text" name="captcha" placeholder="Enter Answer" required>
        </div>

        <button type="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="{{ route('user.login') }}">Login here</a></p>
</div>
@endsection