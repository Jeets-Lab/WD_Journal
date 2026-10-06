@extends('layouts.app')
@section('title', 'Friends')
@section('content')

<div class="card">

    <h2>Friends</h2>
    <h3>People from {{ $user->city }}</h3>

    @if($sameCityUsers->count() > 0)

        @foreach($sameCityUsers as $person)
            <p>
                <strong>{{ $person->name }}</strong> ({{ $person->username }})

                {{-- Practical 2: Accept / Ignore --}}
                @if($person->friend_status === 'accepted')
                    <button type="button" disabled>Friends ✓</button>

                @elseif($person->friend_status === 'ignored')

                    <button type="button" disabled>Ignored</button>
                
                @elseif($person->friend_status === 'pending' && $person->friend_direction === 'sent' )
                    <button type="button" disabled>Pending</button>


                @elseif($person->friend_status === 'pending' && $person->friend_direction === 'received')
                    <button type="button" disabled>Pending</button>

                    <form method="POST"
                          action="{{ route('friends.accept', $person->id) }}"
                          style="display:inline;">
                        @csrf
                        <button type="submit">Accept</button>
                    </form>
                    <form method="POST"
                          action="{{ route('friends.ignore', $person->id) }}"
                          style="display:inline;">
                        @csrf
                        <button type="submit">Ignore</button>
                    </form>

                @else
                    <form method="POST"
                          action="{{ route('friends.send',$person->id)}}"
                          style="display:inline;">
                        @csrf
                        <button type="submit">Request</button>
                    </form>

                    <form method="POST"
                          action="{{ route('friends.ignore',$person->id) }}"
                          style="display:inline;">
                        @csrf
                        <button type="submit">Ignore</button>
                    </form>
                @endif
            </p>
        @endforeach

    @else
        <p>No other users found from your city.</p>
    @endif

</div>

<div class="card">

    <h3>Pending Friend Requests</h3>

    @if($pendingRequests->count() > 0)

        @foreach($pendingRequests as $request)
            <p>
                <strong>{{ $request->sender->name }}</strong> ({{ $request->sender->username }})

                <form method="POST" action="{{ route('friends.accept', $request->sender->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit">Accept</button>
                </form>

                <form method="POST" action="{{ route('friends.ignore', $request->sender->id) }}" style="display:inline;">
                    @csrf
                    <button type="submit">Ignore</button>
                </form>
            </p>
        @endforeach

    @else
        <p>No pending requests.</p>
    @endif

</div>

<div class="card">

    <h3>My Friends</h3>

    @if($acceptedFriends->count() > 0)

        @foreach($acceptedFriends as $friend)
            {{-- Show the OTHER person's name, not the current user's --}}
            @if($friend->userid == $user->id)
                <p>{{ $friend->receiver->name }} ({{ $friend->receiver->username }})</p>
            @else
                <p>{{ $friend->sender->name }} ({{ $friend->sender->username }})</p>
            @endif
        @endforeach

    @else
        <p>You don't have any friends yet.</p>
    @endif

</div>

@endsection
