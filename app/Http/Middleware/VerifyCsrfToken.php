<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/register',          // Exclude registration form from CSRF verification
        '/',                  // Exclude login form from CSRF verification
        '/login',

        '/api/register',          // Exclude registration form from CSRF verification
        '/',                  // Exclude login form from CSRF verification
        '/api/login',

        'api/register',
        'api/login',
        // Exclude login submission from CSRF verification
    ];
}
