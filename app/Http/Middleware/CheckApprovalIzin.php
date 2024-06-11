<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckApprovalIzin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Auth::user();

        if ($admin && $admin->aksesAdmin && $admin->aksesAdmin->approval_izin == 1) {
            view()->share('isAdmin', false);
        } else {
            view()->share('isAdmin', true);
        }

        return $next($request);
    }
}
