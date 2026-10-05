<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Social Netowrk')</title>
</head>
<body>
<div>
    <aside>
        <div>
            <div><h1>Social Network</h1></div>
            <div><h2>Admin Panel</h2></div>

            <div>
                <a href="{{ route('admin.home') }}">Dashboard</a>
                <a href="{{ route('admin.users') }}">Manage Users</a>

                <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </aside>
    <main>
        <div>
            @yield('content')   
        </div>
    </main>
</div>
</body>
</html>