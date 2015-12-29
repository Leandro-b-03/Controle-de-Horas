<?php

namespace App\Http\Middleware;

use Closure;
use App\Timesheet;
use Carbon\Carbon;

class LunchTime
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
        $today = new Carbon();

        $timesheet = Timesheet::where('user_id', $request->user()->getEloquent()->id)->where('lunch_start', '!=', '00:00:00')->where('lunch_end', '00:00:00')->get()->first();

        $lunch_time = new Carbon($timesheet->lunch_start);

        $diffTime = $lunch_time->diffInMinutes($today);

        $hour = $diffTime / 60;

        if ($timesheet && ($hour < 1))
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect()->to('lock');
            }
        }

        return $next($request);
    }
}
