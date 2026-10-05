<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;

class FriendController extends Controller
{
  
    private function findRelationship(int $userA, int $userB): ?Friend
    {
        return Friend::where(function ($query) use ($userA, $userB) {
                $query->where('userid', $userA)
                      ->where('friend_userid', $userB);
            })
            ->orWhere(function ($query) use ($userA, $userB) {
                $query->where('userid', $userB)
                      ->where('friend_userid', $userA);
            })
            ->first();
    }

    public function index()
    {
        $user = User::findOrFail(session('user_id'));

        $sameCityUsers = User::where('city', $user->city)
            ->where('id', '!=', $user->id)
            ->where('block', false)
            ->get();

        foreach ($sameCityUsers as $person) {
            $relationship = $this->findRelationship($user->id, $person->id);

            $person->friend_status    = $relationship ? $relationship->status : null;
            $person->friend_record_id = $relationship ? $relationship->id     : null;

            // 'sent'     = current user sent the request
            // 'received' = current user received the request
            $person->friend_direction = $relationship
                ? ($relationship->userid == $user->id ? 'sent' : 'received')
                : null;
        }

        // --- Section 2: Incoming pending requests ---
        $pendingRequests = Friend::where('friend_userid', $user->id)
            ->where('status', 'pending')
            ->with('sender')   // eager-load sender to avoid N+1 queries
            ->get();

        // --- Section 3: Accepted friends (on either side of the relationship) ---
        $acceptedFriends = Friend::where(function ($query) use ($user) {
                $query->where('userid', $user->id)
                      ->orWhere('friend_userid', $user->id);
            })
            ->where('status', 'accepted')
            ->with(['sender', 'receiver'])
            ->get();

        return view('user.friends', compact(
            'user',
            'sameCityUsers',
            'pendingRequests',
            'acceptedFriends'
        ));
    }

    public function sendRequest($id)
    {
        $user = User::findOrFail(session('user_id'));

        // Cannot send a friend request to yourself
        if ($user->id == $id) {
            return back();
        }

        $recipient = User::findOrFail($id);

        // Only create a new request if no relationship already exists
        if (! $this->findRelationship($user->id, $recipient->id)) {
            Friend::create([
                'userid'        => $user->id,
                'friend_userid' => $recipient->id,
                'status'        => 'pending',
            ]);
        }

        return redirect()->route('user.friends');
    }

    public function respondToSameCity($id, $status)
    {
        $user = User::findOrFail(session('user_id'));

        if (!in_array($status, ['accepted', 'ignored'])) {
            abort(400);
        }

        $otherUser = User::findOrFail($id);

        // Do not allow responding to yourself.
        if ($otherUser->id == $user->id) {
            return redirect()->route('user.friends');
        }

        // Practical 2 Section A is for users from the same city.
        if ($otherUser->city !== $user->city) {
            abort(403);
        }

        $relationship = $this->findRelationship($user->id, $otherUser->id);

        if ($relationship) {
            $relationship->status = $status;
            $relationship->save();
        } else {
            Friend::create([
                'userid'        => $user->id,
                'friend_userid' => $otherUser->id,
                'status'        => $status,
            ]);
        }

        return redirect()->route('user.friends');
    }

    public function acceptRequest($id)
    {
        $user = User::findOrFail(session('user_id'));

        $friendRequest = Friend::where('id', $id)
            ->where('friend_userid', $user->id)  // must be the receiver
            ->where('status', 'pending')
            ->firstOrFail();

        $friendRequest->status = 'accepted';
        $friendRequest->save();

        return redirect()->route('user.friends');
    }

    public function ignoreRequest($id)
    {
        $user = User::findOrFail(session('user_id'));

        $friendRequest = Friend::where('id', $id)
            ->where('friend_userid', $user->id)  // must be the receiver
            ->where('status', 'pending')
            ->firstOrFail();

        $friendRequest->status = 'ignored';
        $friendRequest->save();

        return redirect()->route('user.friends');
    }

}
