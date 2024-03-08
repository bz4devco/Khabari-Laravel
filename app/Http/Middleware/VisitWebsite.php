<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Visit;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitWebsite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if((Visit::where('created_at', 'like', '%' . Carbon::now()->format('Y-m-d') . '%')->where('ip',  $request->ip())->count()) == 0) {
            Visit::create(['ip' => $request->ip()]);
        }

        if(Auth::check()){
            if((User::where('id', auth()->user()->id)->where('activation_date', 'like', '%' . Carbon::now()->format('Y-m-d') . '%')->count()) == 0){
                User::where('id', auth()->user()->id)->update(['activation_date' => Carbon::now()]);
            }
        }

        return $next($request);
    }
}
