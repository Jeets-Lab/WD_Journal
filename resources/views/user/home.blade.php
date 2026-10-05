@extends('layouts.app')
@section('title', 'Home')
@section('content')

<div>
    <h1>Welcome to Your Dashboard</h1>

    <p><a href="{{ route('user.profile') }}">View Profile</a></p>
    <p><a href="{{ route('user.friends') }}">Friends</a></p>
</div>

@endsection