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
        for($i = 0; $i < 6; $i++) {
            //Any day at 13:00
            $this->assertTrue(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->addDay($i)->hour(13)->minute(0)));

            //Any day at 18:59
            $this->assertTrue(DeliveryTime::isOpen(Carbon::now()->hour(18)->minute(59)));
        }

        //Monday 00:59
        $this->assertTrue(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->hour(0)->minute(59)));
    }

    public function testFalseOpeningTimes()
    {
        for($i = 0; $i < 6; $i++) {
            //Any day at 02:01
            $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->addDay($i)->hour(2)->minute(1)));
        }

        //Tuesday 01:30
        $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->addDay(1)->hour(1)->minute(30)));

        //Friday 01:30
        $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->addDay(4)->hour(1)->minute(30)));

        //Monday 01:01
        $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->startOfWeek()->hour(1)->minute(1)));

        //Sunday 01:01
        $this->assertFalse(DeliveryTime::isOpen(Carbon::now()->endOfWeek()->hour(1)->minute(1)));
    }
}
