<?php

namespace App\Http\Middleware;

use Closure;
use Log;

class PrivateAccountAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      
      if(! $request->user()->accounts()->get()->contains('id', $request->id)){
        return redirect()->back();
      }

      return $next($request);

    }
}
