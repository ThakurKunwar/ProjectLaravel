<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //

    public function toggle(Post $post)
    {

        $user = auth()->guard()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            $post->likes()->detach($user->id);
            $status = 'unliked';
        } else {
            $post->likes()->attach($user->id);
            $status = 'liked';
        }

        return response()->json(
            [
                'status' => $status,
                'likes_count' => $post->likes()->count(),

            ]
        );
    }
}
