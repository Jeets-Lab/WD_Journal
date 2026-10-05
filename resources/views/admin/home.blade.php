@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')

<div>
    <h1>Welcome, Adminstrator </h1>
    <p>Manage your Social Network from this dashboard.</p>
</div>
<div>
    <h2>Manage Users</h2>
    <p>View registered users and manage their account status.</p>
    <a href="{{ route('admin.users') }}">View Users</a>
</div>

@endsection