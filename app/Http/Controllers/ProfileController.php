<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Investigator Profile
     */
    public function index(Request $request)
    {
        return view('dashboard.pages.profile', [
            'player' => $request->attributes->get('player'),
        ]);
    }
}