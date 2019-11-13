<?php

namespace App\Http\Middleware;

use App\Point;
use App\User;
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
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function handle($request, Closure $next)
    {
        $currentPoint = Point::where('user_id', Auth::id())->whereNull('finished')->first();

        $data = [
            'currentPoint' => $currentPoint,
        ];

        View::share('currentPoint', $data);

        return $next($request);
    }
}
