<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Social Netowrk')</title>
</head>
<body>
    <nav>
        <div>
            <a href="{{ route('user.home') }}"><h1>Social Network</h1></a>

            <div>
                <a href="{{ route('user.home') }}">Home</a>
                <a href="{{ route('user.profile') }}">Profile</a>
                <a href="{{ route('user.friends') }}">Friends</a>

                <form method="POST" action="{{ route('user.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>

        </div>
    </nav>

    <div>
        @yield('content')   
    </div>
    
</body>
</html>