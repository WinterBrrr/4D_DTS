<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class RequireHandlerDepartment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->role === 'handler') {
            $profile = UserProfile::where('user_id', $user->id)->first();
            if (!$profile || empty($profile->department)) {
                // Allow only profile and logout routes
                $allowedRoutes = [
                    'handler.profile',
                    'logout',
                ];
                if (!in_array($request->route()->getName(), $allowedRoutes)) {
                    return redirect()->route('handler.profile')->with('require_department', true)->with('error', 'Please add your department to continue.');
                }
            }
        }
        return $next($request);
    }
}
