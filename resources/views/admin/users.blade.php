@extends('layouts.admin')
@section('title', 'Manage Users')
@section('content')

<div>
    <h1>Manage Users</h1>
    <p>View registered users and manage their account status.</p>
</div>
@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>   
@endif

<div>
    @if($users->count() > 0)
 
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>City</th>
                    <th>Profile Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->city }}</td>
                        <td>
                        @if($user->profile_image)
                            <img src="{{ asset($user->profile_image) }}" alt="Profile Image" width="50">    
                        @else
                            No Image
                        @endif
                        </td>
                        <td>
                            @if($user->block)
                                Blocked
                            @else
                                Active
                            @endif
                        <td>
                            @if($user->block)
                                <form method="POST" action="{{ route('admin.unblock', $user->id) }}">
                                    @csrf
                                    <button type="submit">Unblock</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.block', $user->id) }}">
                                    @csrf
                                    <button type="submit">Block</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No users found.</p>
    @endif
</div>
@endsection