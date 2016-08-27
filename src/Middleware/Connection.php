<?php

namespace Sawfly\Visitors\Middleware;

use Event;
use Closure;
use Sawfly\Visitors\Events\ConnectionEvent;

class Connection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Event::fire(new ConnectionEvent($request));
        return $next($request);
    }
}
