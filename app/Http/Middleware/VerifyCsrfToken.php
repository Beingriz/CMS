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
        'https://0cfc-2406-7400-104-f642-dd04-c127-d7c9-be7e.ngrok-free.app/incoming/twilio', // Add your webhook endpoint here
    ];
}
