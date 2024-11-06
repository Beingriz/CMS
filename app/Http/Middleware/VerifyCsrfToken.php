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
        'https://75e1-2406-7400-98-ca36-b184-6f7c-63a7-c36d.ngrok-free.app/incoming_msg','https://75e1-2406-7400-98-ca36-b184-6f7c-63a7-c36d.ngrok-free.app/test-webhook'
    ];

}
