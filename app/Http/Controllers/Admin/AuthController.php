<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create()
    {
        return view('admin.auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([

            'email' => ['required','email'],

            'password' => ['required'],

        ]);

        $admin = Admin::where(
            'email',
            $request->email
        )->first();

        if (
            !$admin ||
            !Hash::check(
                $request->password,
                $admin->password
            )
        ) {

            return back()->withErrors([

                'email' => 'Invalid credentials.'

            ]);

        }

        Auth::guard('admin')->login($admin);

        return redirect()->route(
            'admin.dashboard'
        );
    }

    public function destroy()
    {
        Auth::guard('admin')->logout();

        return redirect()->route(
            'admin.login'
        );
    }
}
