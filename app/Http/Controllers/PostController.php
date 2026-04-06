<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use AuthorizesRequests;
    //
    public function store(Request $request)
    {


        $data = $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|image|mimes:jpg,jpeg,png'
            ]
        );


        //some changes in image before storing 
        $image = $request->file('image');
        $path = $image->store("public/images");



        Post::create(
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'image' => $path,
                'user_id' => auth()->guard()->id(),
            ]
        );


        return redirect('/home')->with('success', 'post uploaded successfully');
    }


    public function allposts()
    {
        $posts = Post::latest()->get();
        return view('viewallposts', compact('posts'));
    }

    public function deletePost(Post $post)
    {

        //unneccessary cause laravel does it for you
        if (!Post::find($post->id)) {
            return back()->with('error', 'post doesnot exist');
        }

        // if (auth()->id() !== $post->user_id) {
        //     return back()->with('error', 'you are not authorized to delete this post ');
        // }

        //using policy
        try {
            $this->authorize('delete', $post);
        } catch (AuthorizationException $e) {
            return back()->with('error', 'you are not authorized');
        }

        $post->delete();
        return back()->with('success', 'post deleted successfully');
    }

    //addcomments
    public function addComment(Request $request)
    {

        $data = $request->validate(
            [
                'body' => 'required',
                'post_id' => 'required|exists:posts,id',
            ]
        );


        //create comment linked to authenticated user
        Comment::create(
            [
                'body' => $data['body'],
                'post_id' => $data['post_id'],
                'user_id' => auth()->guard()->id(), //attach to current user

            ]
        );
        return back();
    }

    // public function viewProfile(Post $post)
    // {


    // return view('viewProfile',compact(post));


    // }
    //view individual post
    public function viewPost(Post $post)
    {

        //eager load user and comments with their users
        $post->load('user', 'comments.user');
        return view('viewpost', compact('post'));
    }
}
