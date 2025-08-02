<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Manager;
use App\Models\ParentUser;
use App\Models\Teacher;
use App\Models\Vice;

class AuthController extends Controller
{
    public function showManagerLogin()
    {
        return view('manager.login');
    }

    public function managerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists in managers table
        $manager = Manager::where('email', $credentials['email'])->first();
        
        if (!$manager) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        // For now, we'll use a simple password check
        // In production, you should use proper password hashing
        if ($manager->password === $credentials['password']) {
            // Store manager info in session
            session(['manager_id' => $manager->id]);
            session(['manager_name' => $manager->name]);
            
            return redirect()->route('manager.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function showParentLogin()
    {
        return view('parent.login');
    }

    public function parentLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $parent = ParentUser::where('email', $credentials['email'])->first();
        
        if (!$parent || $parent->password !== $credentials['password']) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        session(['parent_id' => $parent->id]);
        session(['parent_name' => $parent->name]);
        
        return redirect()->route('parent.dashboard');
    }

    public function showTeacherLogin()
    {
        return view('teacher.login');
    }

    public function teacherLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $teacher = Teacher::where('email', $credentials['email'])->first();
        
        if (!$teacher || $teacher->password !== $credentials['password']) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        session(['teacher_id' => $teacher->id]);
        session(['teacher_name' => $teacher->name]);
        
        return redirect()->route('teacher.dashboard');
    }

    public function showViceLogin()
    {
        return view('vice.login');
    }

    public function viceLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $vice = Vice::where('email', $credentials['email'])->first();
        
        if (!$vice || $vice->password !== $credentials['password']) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        session(['vice_id' => $vice->id]);
        session(['vice_name' => $vice->name]);
        
        return redirect()->route('vice.dashboard');
    }

    // Registration Methods
    public function registerParent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        ParentUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('parent.login')->with('success', 'Registration successful! Please login with your credentials.');
    }

    public function registerTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:6|confirmed',
            'subject' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'qualification' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'subject' => $request->subject,
            'experience_years' => $request->experience_years ?? 0,
            'qualification' => $request->qualification,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'active',
        ]);

        return redirect()->route('teacher.login')->with('success', 'Registration successful! Please login with your credentials.');
    }
}
