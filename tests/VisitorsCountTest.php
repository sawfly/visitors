<?php

class VisitorsCountTest extends TestCase
{
    use \Illuminate\Foundation\Testing\DatabaseMigrations;
    /**
     * @var \Sawfly\Visitors\Console\Commands\VisitorsCount
     */
    private $vc;
    /**
     * @var \Carbon\Carbon::yesterday()->format('Y-m-d')
     */
    private $yesterday;

    /**
     * Starting sets
     */
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->vc = new \Sawfly\Visitors\Console\Commands\VisitorsCount();
        $this->yesterday = \Carbon\Carbon::yesterday()->format('Y-m-d');
        \DB::table('visitors')->insert(['ip' => rand(0, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' .
                rand(0, 255), 'agent' => str_random(66), 'locale' => array_rand(['en', 'ua'], 1),
                'created_at' => $this->yesterday]
        );
    }

    /**
     * test handler() if there are visitors from yesterday
     */
    public function testHandler()
    {
        $this->assertInstanceOf(\Sawfly\Visitors\Console\Commands\VisitorsCount::class, $this->vc);
        $count = $this->vc->handle();
        $this->seeInDatabase('statistics', ['visitsPerDate' => $count, 'date' => $this->yesterday]);
        $this->assertEquals(1, $count);
    }

    /**
     * delete all rows from tables
     */
    public function cleanUp()
    {
        \DB::delete('delete from visitors');
        \DB::delete('delete from statistics');
    }

    /**
     * test handler() if there are no visitors from yesterday
     */
    public function testHandlerNoVisits()
    {
        $this->cleanUp();
        $this->assertInstanceOf(\Sawfly\Visitors\Console\Commands\VisitorsCount::class, $this->vc);
        $count = $this->vc->handle();
        $this->seeInDatabase('statistics', ['visitsPerDate' => $count, 'date' => $this->yesterday]);
        $this->assertEquals(0, $count);
    }
}