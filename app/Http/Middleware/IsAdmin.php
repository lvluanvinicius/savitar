<?php

namespace App\Http\Middleware;

use App\Models\GroupsRelated;
use App\Traits\AppResponse;
use App\Traits\LoadMessages;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    use AppResponse, LoadMessages;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->server());
        if (checkNivel(auth()->user()->id) == 0 || checkNivel(auth()->user()->id) == 1) {
            return $next($request);
        }
        return $this->error($this->getMessage("apierror", "ErrorUnauthorizedRoute"), 401);
    }
}
