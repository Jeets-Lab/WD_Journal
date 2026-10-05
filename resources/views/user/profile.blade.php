@extends('layouts.app')
@section('title', 'Profile')
@section('content')

<div>
    <h1>My Profile</h1>

    <div>
        @if($user->profile_image)
            <div>
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" width="150">
            </div>
        @else
            <p>No profile image uploaded.</p>
        @endif
        
        <p><strong>Username:</strong> {{ $user->username }}</p>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Mobile:</strong> {{ $user->mobile }}</p>
        <p><strong>City:</strong> {{ $user->city }}</p>
</div>

@endsection