<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleAllow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        /**
         * @var \App\Models\User $user
         */
        $user = auth()->user();
        if(!$user->hasAnyRole()){
            $user->assignRole(Role::where('id', $user->role_id)->first()->name);
        }

        $route = $request->route()->getName();


        if(!$user->hasAnyRole(['Admin']) && !$user->hasPermissionTo($route)){
            // abort(403);
        }

        return $next($request);
    }
}
