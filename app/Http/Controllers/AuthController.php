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

        // Check if user exists in database
        $user = User::where('employee_id', $request->employee_id)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Successful authentication
            Session::put('user', [
                'employee_id' => $user->employee_id,
                'name' => $user->name,
                'role' => $user->role,
                'email' => $user->email,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname
            ]);

            return redirect()->route('userDashboard');
        }

        // Failed authentication
        return back()->withErrors(['employee_id' => 'Invalid credentials']);
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
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    Session::put('user', [
        'employee_id' => $user->employee_id,
        'name' => $user->name,
        'role' => $user->role
    ]);

    return redirect()->back()->with('success', 'Registration successful! Welcome, ' . $user->name . '. You will be redirected shortly.');
}
public function store(Request $request)
{
    $validated = $request->validate([
        'lastname' => 'required|string|max:100',
        'firstname' => 'required|string|max:100',
        'employee_id' => 'required|string|unique:users',
        'password' => 'required|min:8|confirmed',
        'role' => 'required|in:admin,staff,encoder,viewer'
    ]);

    User::create([
        'lastname' => $validated['lastname'],
        'firstname' => $validated['firstname'],
        'employee_id' => $validated['employee_id'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role']
    ]);

    return redirect()->route('login')->with('success', 'Registration pending admin approval');
}

    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login');
    }
}