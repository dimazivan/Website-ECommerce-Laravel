<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // dd(
        //     $request->user()->role,
        // );

        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        } else {
            // return redirect('/error');
            Alert::warning('Ups...', 'Terjadi Kesalahan');
            return redirect('/error');
        }
        Alert::warning('Ups...', 'Terjadi Kesalahan');
        return redirect('/error');
        // return redirect('/error');
    }
}
