<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Session::has('employee_id')) {
            return view('userDashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'password' => 'required',
        ]);

        // Mock authentication
        Session::put('user', ['employee_id' => $request->username, 'role' => 'Administrator']);
        return view('userDashboard');
    }

    public function showRegisterForm()
    {
        if (Session::has('user')) {
            return view('userDashboard');
        }
        return view('auth.register');
    }

  public function register(Request $request)
{
    $request->validate([
        'lastname' => 'required|string|max:255',
        'firstname' => 'required|string|max:255',
        'employee_id' => 'required|unique:users,employee_id',
        'password' => 'required|confirmed|min:8',
        'role' => 'required|in:admin,staff,encoder,viewer',
    ]);

    $user = User::create([
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'name' => $request->firstname . ' ' . $request->lastname,
        'employee_id' => $request->employee_id,
        'email' => $request->employee_id . '@dswd.gov.ph',
        'password' => bcrypt($request->password), // ← FIXED: Hash password
        'role' => $request->role,
    ]);

    Session::put('user', [
        'employee_id' => $user->employee_id,
        'name' => $user->name,
        'role' => $user->role
    ]);

    return redirect()->route('dashboard'); // ← Use redirect, not view
}


    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login');
    }
}