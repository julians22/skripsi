<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Services\Transactions\SalesServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesStateController extends Controller
{
    protected $salesServices;

    public function __construct(SalesServices $salesServices)
    {
        $this->salesServices = $salesServices;
    }

    public function getSales(Request $request)
    {
        $start_date = $this->validateDateFormat($request->start_date);
        $end_date = $this->validateDateFormat($request->end_date);

        if ($start_date && $end_date) {
            $sales = Sales::query();
            $sales->whereBetween('created_at', [$start_date, $end_date]);
            $sales = $sales->get();

            return response()->json([
                'reports' => $sales,
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);

    }

    private function validateDateFormat($date, $format = "Y-m-d")
    {
        try {
            $d = Carbon::createFromFormat($format, $date);
            return $date;
        } catch (\Throwable $th) {
            return false;
        }
    }

}
