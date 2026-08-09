<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanManageStudentsOrFees
{
    /**
     * Allow users who can manage students OR fees (e.g. fee collectors who
     * need to look up students by roll without full student management).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()->canAny(['manage students', 'manage fees'])) {
            abort(403);
        }

        return $next($request);
    }
}
