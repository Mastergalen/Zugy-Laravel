<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Zugy\Facades\DeliveryTime;

class DeliveryTimeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testTrueOpeningTimes()
    {
        //Any day at 01:00
        $this->assertTrue(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->hour(13)->minute(0)));

        //Any day at 18:59
        $this->assertTrue(DeliveryTime::isOpen(Carbon::now()->hour(18)->minute(59)));

        //Monday 01:30
        $this->assertTrue(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->hour(1)->minute(30)));
    }

    public function testFalseOpeningTimes()
    {
        //Tuesday 01:30
        $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->addDay(1)->hour(1)->minute(30)));

        //Friday 01:30
        $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->addDay(4)->hour(1)->minute(30)));

        //Monday 02:01
        $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->hour(2)->minute(1)));
    }
}
