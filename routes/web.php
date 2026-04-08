<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $posts = Post::all();
    return view('welcome', compact('posts'));
});

Route::get('/signup', function () {
    return view('auth.signup');
});



Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/verify-email', [AuthController::class, 'verifyEmail']);
Route::get('/login', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'postLogin']);
//profile
Route::get('/profile/{user}', [HomeController::class, 'seeProfile']);

//for forgetpassword
Route::get('/forget-password', [HomeController::class, 'forgetPassword']);
Route::post('/forget-password', [HomeController::class, 'sendLink']);

//for sending link for forgetpassword
Route::get("/reset-password", [HomeController::class, 'resetPassword']);

//actually changing the password
Route::post('/update-password', [HomeController::class, 'newPassword']);



Route::get('/home', [HomeController::class, 'home'])->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);

    //post
    Route::post('/create-post', [PostController::class, 'store']);
    // Route::get('/profile/{name}', PostController::class, 'viewProfile');

    //setting
    Route::get('/settings/{user}', [HomeController::class, 'settings']);
    //password
    Route::get('/settings/{user}/password', [HomeController::class, 'updatePassword'])->name('settings.updatePassword');
    Route::put('/settings/{user}/password', [HomeController::class, 'changePassword'])->name('settings.updatePassword');

    //username
    Route::get('/settings/{user}/editUser', [HomeController::class, 'updateUsername']);
    Route::put('/settings/{user}/editUser', [HomeController::class, 'changeUsername']);
    //delete a post
    Route::delete('/delete-post/{post}', [PostController::class, 'deletePost']);

    //getallpost in Allpost
    Route::get('/allposts', [PostController::class, 'allposts']);

    //add a comment to a post
    Route::post('/comments', [PostController::class, 'addComment']);

    //for like
    Route::post('/post/{post}/like', [LikeController::class, 'toggle'])->name('post.like');

    //for follow
    Route::post('/follow/{user}', [FollowController::class, 'follow']);

    //for profile changes in setting
    Route::get('/settings/{user}/profile', [HomeController::class, 'settingsProfile'])->name('settings.changeProfile');
});

Route::get('/post/{post}', [PostController::class, 'viewPost']);
