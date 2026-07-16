<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\AuthenticationService;

class ActivationController extends Controller
{
    public function __construct(
        protected AuthenticationService $authentication
    ) {
    }

    public function create(string $account_code)
    {
        return $this->authentication
            ->activationForm($account_code);
    }

    public function store(
        Request $request,
        string $account_code
    ) {
        return $this->authentication
            ->activate(
                $request,
                $account_code
            );
    }
}