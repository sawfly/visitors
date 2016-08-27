<?php

namespace Sawfly\Visitors\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class VisitorsCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitors:count';

    /**
     * @var string
     */
    protected $description = 'Count visitors at yesterday';

    /**
     * VisitorsCount constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function handle()
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $visitors = \DB::table('visitors')->where('created_at', $yesterday)->count();
        \DB::table('statistics')->insert(['visitsPerDate' => $visitors, 'date' => $yesterday]);
        return $visitors;
    }
}
