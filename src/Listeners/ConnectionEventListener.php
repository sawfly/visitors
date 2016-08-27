<?php

namespace Sawfly\Visitors\Listeners;

use Carbon\Carbon;
use Sawfly\Visitors\Events\ConnectionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Sawfly\Visitors\Visitor;

class ConnectionEventListener
{
    /**
     * ConnectionEventListener constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param ConnectionEvent $event
     * @return string
     */
    public function handle(ConnectionEvent $event)
    {
        $now = Carbon::now()->format('Y-m-d');
        $request = $event->getRequest();
        $visitor = Visitor::where([['ip', $request->getClientIp()], ['agent', $request->header("user-agent")],
            ['created_at', $now]])->first();
        if (!$visitor) {
            try {
                (new Visitor())->insert(['ip' => $request->getClientIp(), 'agent' => $request->header("user-agent"),
                    "locale" => $request->header("accept-language"), 'created_at' => $now]);
            } catch (\Exception $e) {
                return 'Visitor not created => ' . $e->getMessage();
            }

        }
    }
}
