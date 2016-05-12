<?php

namespace Zugy\Charts;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Charts
{
    public function chart30dRevenue() {

    }

    public function revenueByDay($start = null, $end = null) {
        if($start === null) {
            $start = Carbon::now()->subDays(30);
        }

        if($end === null) {
            $end = Carbon::now();
        }

        $rows = DB::select("
            SELECT DATE(t.date) AS day, SUM(t.total) AS total
            FROM (
                SELECT o.id, o.created_at AS 'date', (SUM(i.final_price) + o.shipping_fee - IFNULL(o.coupon_deduction, 0)) AS 'total'
                FROM orders o
                JOIN order_items i
                ON o.id = i.order_id
                WHERE o.order_status != 4 AND o.created_at BETWEEN ? AND ?
                GROUP BY o.id
            ) t
            GROUP BY day
        ", [$start, $end]);

        //Fill in missing days with zero

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($start, $interval, $end);

        $result = [
            'x' => [],
            'y' => []
        ];
        $i = 0;
        foreach($period as $day) {
            $date = $day->format('Y-m-d');

            if($rows[$i]->day == $date) {
                $result['x'][] = $date;
                $result['y'][] = $rows[$i]->total;
                $i++;
            } else {
                $result['x'][] = $date;
                $result['y'][] = 0;
            }


        }

        return $result;
    }
}