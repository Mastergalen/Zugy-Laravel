<?php

namespace Zugy\DeliveryTime;

use Carbon\Carbon;

class DeliveryTime
{
    /**
     * Validate delivery time, throws exceptions if it fails
     * @param Carbon $delivery_time
     * @throws Exceptions\ClosedException
     * @throws Exceptions\PastDeliveryTimeException
     */
    public function isValidDeliveryTime(Carbon $delivery_time) {
        //Check that delivery time is in future
        $cutoff_time = Carbon::now()->addMinutes(30);

        if($delivery_time->lt($cutoff_time)) {
            throw new Exceptions\PastDeliveryTimeException();
        }

        if(!$this->isOpen($delivery_time)) {
            throw new Exceptions\ClosedException();
        }
    }

    /**
     * Check if for given time we are delivering or not
     * Open everyday from 1pm to 1am
     * @param Carbon $time
     * @return bool
     */
    public function isOpen(Carbon $time) {
        $hour = $time->hour;

        switch ($time->dayOfWeek) {
            case Carbon::SATURDAY:
            case Carbon::SUNDAY:
            case Carbon::MONDAY:
                return ($hour < 1 || $hour >= 13);
            default:
                return ($hour < 1 || $hour >= 13);
        }
    }

    /**
     * Generate array of days for <select>
     * @param $days
     * @return array
     */
    public function daySelect($days) {
        $return = [];
        
        for($i = 0; $i < $days; $i++) {
            $currentDay = Carbon::now()->addDays($i);
        
            $dayThreshold = $currentDay->copy();
            $dayThreshold->hour = 23;
            $dayThreshold->minute = 5;
            if($i == 0 && $currentDay->gt($dayThreshold) ) continue; //Don't show day if time is after 23:05

            $return[] = $currentDay;
        }
        
        return $return;
    }
}