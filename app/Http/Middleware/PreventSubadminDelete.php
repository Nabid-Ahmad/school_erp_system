<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventSubadminDelete
{
    /**
     *
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('delete') && auth()->check() && auth()->user()->role === 'subadmin') {
            abort(403, 'Subadmins are not allowed to delete records.');
        }

        return $next($request);
    }
}
