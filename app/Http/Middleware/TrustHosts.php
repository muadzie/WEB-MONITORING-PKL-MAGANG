<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    public function hosts(): array
    {
        return [
            'localhost',
            '127.0.0.1',
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}