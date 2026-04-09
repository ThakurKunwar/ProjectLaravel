<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPasswordMail;
use App\Models\ForgetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;




class HomeController extends Controller
{
    //
    public function home()
    {
        $posts = auth()->guard()->user()->posts()->latest()->get();
        return view('home', compact('posts'));
    }

    public function settings(User $user)
    {


        return view('settings', compact('user'));
    }

    public function seeProfile(User $user)
    {
        $posts = $user->posts()->latest()->get();
        return view('profile', compact('user', 'posts'));
    }
    //for entering the changepassword
    public function updatePassword(User $user)
    {

        return view('settings.password', compact('user'));
    }
    //for actually changing a password 
    public function changePassword(Request $request, User $user)
    {
        if (auth()->user()->id != $user->id) {
            abort(403);
        }

        $data = $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required',
                'new_password_confirmation' => 'required',
            ]
        );

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->with('error', 'password is not correct');
        }

        if ($data['current_password'] === $data['new_password']) {
            return back()->with('error', 'purano password halna painna');
        }

        if ($data['new_password'] !== $data['new_password_confirmation']) {
            return back()->with('error', ' naya password vayana');
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return back()->with('success', 'password changed successfully');
    }

    //for the page of changing username
    public function updateUsername(User $user)
    {
        return view('settings.username', compact('user'));
    }

    public function changeUsername(Request $request, User $user)
    {
        $data = $request->validate(
            [
                'username' => 'required',
            ]
        );

        if ($user->name != $data['username']) {

            if ($user->updated_at->gt(Carbon::now()->subHours(24))) {
                $TimeLeft = 24 - (int)$user->updated_at->diffInHours(Carbon::now());
                return back()->with('error', 'couldnt change the name try again after ' . $TimeLeft . ' hour');
            }
            $user->update(
                ['name' => $data['username']]
            );
            return back()->with('success', 'username changed successfully');
        } else {
            return back()->with('error', 'cannot change to same username');
        }
    }

    //for forgetpassword get
    public function forgetPassword()
    {

        if (auth()->guard()->check()) {
            $email = auth()->guard()->user()->email;
            return view('forgetpassword', compact('email'));
        }
        return view('forgetpassword');
    }
    //for forgetpassword post
    public function sendLink(Request $request)
    {

        if (auth()->guard()->check()) {
            $email = @auth()->guard()->user()->email;
        } else {
            $request->validate(
                [
                    'email' => ['required', 'email', Rule::exists('users', 'email')]
                ]
            );
            $email = $request->email;
        }


        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'email doesnot exist');
        }
        if (!$user->is_verified) {
            return redirect('/login')->with('success', 'please verify your email first');
        }


        $token = Str::random(40);

        ForgetPassword::create(
            [
                'email' => $email,
                'token' => $token,
                'user_id' => $user->id,
            ]
        );
        $link = url('/reset-password/?email=' . $email . '&token=' . $token);

        Mail::to($email)->queue(new ForgetPasswordMail($link));

        return back()->with('success', 'link has been sent please check your email');
    }

    public function resetPassword(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        $user = ForgetPassword::where('email', $email)
            ->where('token', $token)->first();

        if (!$user) {
            return redirect('forget-password')->with('error', 'invalid reset Link');
        }

        $expiryMinutes = 30;

        if ($user->created_at->addMinutes($expiryMinutes)->isPast()) {
            $user->delete();

            return redirect('/forget-password')->with('error', 'this reset link has been expired please request new to change password');
        }

        return view('auth.resetpassword', compact('email', 'token'));
    }

    //for password change from forgetpassword
    public function newPassword(Request $request)
    {

        $data = $request->validate(
            [
                'token' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed',
            ]
        );


        $reset = ForgetPassword::where('email', $data['email'])
            ->where('token', $data['token'])->first();

        if (!$reset) {
            return redirect('/forget-password')->with('error', 'something went wrong please try later');
        }

        if ($reset->created_at->addMinutes(30)->isPast()) {
            $reset->delete();
            return redirect('/forget-password')->with('error', 'your reset link has expired please request new one');
        }


        $user = User::where('email', $reset['email'])->first();
        if (Hash::check($data['password'], $user->password)) {
            return back()->with('error', 'please use a different password');
        }
        $user->password = Hash::make($data['password']);
        $user->save();

        $reset->delete();

        return redirect('/login')->with('success', 'password reset successfully');
    }

    public function settingsProfile()
    {
        return view('settings.profile');
    }

    public function updateSettingsProfile(Request $request)
    {


        $user = auth()->guard()->user();
        $request->validate(
            [

                'birthdate' => ['date'],

            ]
        );

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->bio = $request->bio;
        $user->location = $request->location;
        $user->website = $request->website;
        $user->birthdate = $request->birthdate;
        $user->email = $request->email;

        $user->save();

        return back()->with('success', 'profile updated successfully');
    }
}
