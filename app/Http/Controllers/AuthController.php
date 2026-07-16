<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\AuthenticationService;

class AuthController extends Controller
{
    public function __construct(
        protected AuthenticationService $authentication
    ) {
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        return $this->authentication
            ->login($request);
    }

    public function destroy(Request $request)
    {
        return $this->authentication
            ->logout($request);
    }
}