<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section as S;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class NavigationMiddleware
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
        if (!$user) {
            return $next($request);
        }
        if (!$user->hasAnyRole()) {
            $user->assignRole(Role::where('id', $user->role_id)->first()->name);
        }
        $navigation = Navigation::make();

        $userPerms = $user->getAllPermissions()->pluck('name')->toArray();
        // DASHBOARD
        $navigation->add('TFF', route('panel.show'), function (S $section) use ($user) {

            $section->add('Panel', route('panel.show'), function (S $section) {
                $section->add('Anasayfa', route('panel.show'));
            }, [
                'class' => '',
                'icon' => 'fas fa-tachometer-alt',
            ]);

            $section->add('FİXTURE', route('team.index'), function (S $section) {
                $section
                    ->add('TEAMS', route('team.index'))
                    ->add('SEASONS', route('season.index'));
            }, [
                'class' => '',
                'icon' => 'fas fa-futbol',
            ]);

            $section->add("USERS", route("user.index"), function (S $section) {
                $section->add("List", route("user.index"), null, [
                    'class' => '',
                    'icon' => 'fas fa-bars',
                ]);
            }, [
                'class' => '',
                'icon' => 'fas fa-users',
            ]);
        });


        view()->share('navigation', $navigation);
        return $next($request);
    }
}
