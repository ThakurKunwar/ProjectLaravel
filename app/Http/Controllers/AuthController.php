<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification as EmailVerificationMail;
use App\Models\EmailVerification;
use App\Models\User;
use auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{
    public function signup(Request $request)
    {

        $data = $request->validate(
            [
                'name' => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required',
                'birthdate' => 'required|date|before:' . now()->subYears(12)->format('Y-m-d'),
                'location' => 'required',


            ],
            [
                //custom error message
                'birthdate.before' => 'you must be 12 year old to create an account',
            ]
        );



        // Create user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_verified' => false,
            'birthdate' => $data['birthdate'],
            'location' => $data['location'],

        ]);

        // Generate token
        $token = Str::random(40);

        // Store token
        EmailVerification::create([
            'email' => $user->email,
            'token' => $token
        ]);



        // Create verification link
        $link = url('/verify-email/?token=' . $token . '&email=' . $user->email);
        Log::info($link);



        Mail::to($user->email)->queue(new EmailVerificationMail($link, $user->name));

        return redirect('/login')->with('success', 'Verification link has been sent! Please check your email.');
        // Send email

    }

    public function verifyEmail(Request $request)
    {

        $token = $request->query('token');
        $email = $request->query('email');


        $record = EmailVerification::where('token', $token)
            ->where('email', $email)->first();

        if ($record) {
            $user = User::where('email', $email)->first();
            $user->is_verified = true;
            $user->save();
            $record->delete();
            return redirect('/login')->withInput()->with('success', "Account has been verified");
        } else {
            return redirect('/login')->withInput()->with('error', 'thankyou but sorry');
        }
    }
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $data = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => 'required',
            ]
        );
        $user = User::where('email', $data['email'])->first();

        if ($user) {

            if ($user->is_verified) {

                if (auth()->guard()->attempt(
                    [
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ]
                )) {
                    return redirect("/home");
                } else {
                    return back()->withInput()->with('error', 'invalid credential');
                }
            } else {
                return back()->withInput()->with('error', 'please verify your email to login');
            }
        } else {
            return back()->withInput()->with('error', 'email doesnot exist');
        }
    }

    public function logout()
    {
        auth()->guard()->logout();
        return redirect('/login');
    }
}
