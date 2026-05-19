<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Handle user sign-in
     */
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('student_id', 'password');
        $credentials['password'] = $request->password;

        $user = User::where('student_id', $credentials['student_id'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('student-home')->with('success', 'Signed in successfully!');
        }

        return back()->withErrors(['student_id' => 'Invalid credentials.'])->withInput();
    }

    /**
     * Handle user sign-up
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|unique:users,student_id',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('student-home')->with('success', 'Account created successfully!');
    }

    /**
     * Handle visitor sign-in
     */
    public function visitorSignin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $request->session()->put('visitor_name', $request->name);
        $request->session()->put('is_visitor', true);

        return redirect()->route('student-home')->with('success', 'Welcome, visitor!');
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        if ($request->session()->has('is_visitor')) {
            $request->session()->forget(['visitor_name', 'is_visitor']);
        } else {
            Auth::logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
