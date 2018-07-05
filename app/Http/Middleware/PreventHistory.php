<?php

/**
 * File prevent history middleware
 *
 * @package App\Http\Middleware
 * @author Rikkei.trihnm
 * @date 2018/07/05
 */

namespace App\Http\Middleware;

use Closure;

class PreventHistory
{
     /**
     * Handle an incoming request.
     *
     * @access public
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);

        return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
                ->header('Pragma','no-cache');
    }
}
