<?php

namespace App\Http\Middleware;

use App\Point;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class PointRecord
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
        $points = Point::where('user_id', Auth::id())->whereDate('started', Carbon::now())->orderBy('started', 'DESC')->get();

        View::share('points', $points);

        return $next($request);
    }
}
