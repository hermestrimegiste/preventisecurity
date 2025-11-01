<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetOrganizationContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // If user doesn't have a current organization set, set the first one
            if (!$user->current_organization_id && $user->organizations->isNotEmpty()) {
                $user->update([
                    'current_organization_id' => $user->organizations->first()->id
                ]);
            }

            // Share organization data with Inertia
            if (app()->bound('inertia')) {
                \Inertia\Inertia::share([
                    'auth.user.current_organization_id' => $user->current_organization_id,
                    'auth.user.organizations' => $user->organizations->map(fn($org) => [
                        'id' => $org->id,
                        'name' => $org->name,
                        'slug' => $org->slug,
                    ]),
                ]);
            }
        }

        return $next($request);
    }
}
