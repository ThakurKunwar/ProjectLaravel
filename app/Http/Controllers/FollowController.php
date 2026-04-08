<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    //

    public function follow(User $user)
    {
        $activeUser = auth()->guard()->user();
        if ($activeUser->id === $user->id) {
            return response()->json(['error' => 'cannot follow yourself'], 400);
        }
        if ($activeUser->following()->where('following_id', $user->id)->exists()) {
            $activeUser->following()->detach($user->id);
            $status = 'unfollowed';
        } else {
            $activeUser->following()->attach($user->id);
            $status = 'followed';
        }


        return response()->json(
            [
                'status' => $status,
                'followers_count' => $user->followers()->count(),
                'following_count' => $user->following()->count(),
            ]
        );
    }
}
