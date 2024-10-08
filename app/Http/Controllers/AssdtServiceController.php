<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssdtServiceConsumptionTable;
use Illuminate\Support\Facades\DB;

class AssdtServiceController extends Controller
{
    public function fetchData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $distinctServiceNames = AssdtServiceConsumptionTable::distinct()->pluck('servicename')->toArray();

        $data = AssdtServiceConsumptionTable::select('user_id', 'servicename', DB::raw('SUM(transamt) as total_charge'))
            ->whereBetween('req_dt', [$startDate, $endDate])
            ->groupBy('user_id', 'servicename')
            ->get();

        $usersData = [];
        foreach ($data as $row) {
            $usersData[$row->user_id]['user_id'] = $row->user_id;
            $usersData[$row->user_id]['services'][$row->servicename] = number_format($row->total_charge, 2, '.', '');
        }

        return response()->json([
            'serviceNames' => $distinctServiceNames,
            'users' => array_values($usersData)
        ]);
    }
}
