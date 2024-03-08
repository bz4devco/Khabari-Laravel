<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content\Report;
use App\Models\Visit;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function getData()
    {
        $daysAgo = 10;
        $visitsCount = [];

        $labels = $this->getLastDays($daysAgo);
        for ($i = 0; $i <= $daysAgo - 1; $i++) {
            $visitsCount[$i] = Visit::whereDate('created_at', now()->subDays($i))->count() ?? 0;
        }

        $visitsCount = array_reverse($visitsCount);


        return response()->json([
            'labels' => $labels,
            'lastVisitsOnTenDays' =>  $visitsCount,
        ]);
    }

    public function getReport()
    {
        $daysAgo = 10;
        $ReportsCount = [];

        $labels = $this->getLastDays($daysAgo);
        for ($i = 0; $i <= $daysAgo - 1; $i++) {
            $ReportsCount[$i] = Report::whereDate('new_date', now()->subDays($i))->count() ?? 0;
        }

        $ReportsCount = array_reverse($ReportsCount);


        return response()->json([
            'labels' => $labels,
            'lastReportsOnTenDays' =>  $ReportsCount,
        ]);
    }


    private function getLastDays($days)
    {
        for ($i = 0; $i < $days; $i++) {
            $labels[] = jdate(Carbon::now()->subDays($i))->format('%A');
        }

        return array_reverse($labels);
    }
}
