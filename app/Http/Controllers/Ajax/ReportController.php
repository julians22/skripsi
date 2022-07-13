<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sales;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function report(Request $request, $trans = 'sales')
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'report_type' => 'required|in:invoice,product',
            'show_report' => 'required|in:monthly,daily',
            'product' => 'sometimes|required_if:report_type,product',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }


        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $report_type = $request->report_type;
        $show_report = $request->show_report;
        $product = $request->product;


        $labels = $this->makeLabels($show_report, $start_date, $end_date);

        $datasets = [
            'data' => []
        ];

        // make sales data
        $datasets['data']['total_'.$trans] = 0;
        $datasets['data']['average'] = 0;

        if ($report_type == 'invoice'){
            $transactions = $this->getTrans($start_date, $end_date, $trans);

        }else{
            $transactions = $this->getProduct($start_date, $end_date, $product, $trans);
        }

        foreach ($labels as $label) {
            // convert Month to number
            $condition = $label;
            $datasets['data'][$trans][$condition] = 0;
            $datasets['data']['total'][$condition] = 0;
            $datasets['data']['product'][$condition] = 0;
            // group transaction by month or day
            foreach ($transactions as $transaction) {
                // increase total transaction
                if ($show_report == 'monthly') {
                    if (date('M', strtotime($transaction->created_at)) == $condition) {
                        // increase sales in same condition
                        $datasets['data'][$trans][$condition] += $transaction->total;

                        // increase sales by 1
                        $datasets['data']['total'][$condition] += 1;

                        $datasets['data']['total_'.$trans] += $transaction->total;
                        // sale detail
                        $details = $transaction->details;
                        foreach ($details as $detail) {
                            $datasets['data']['product'][$condition] += $detail->quantity;
                        }
                    }
                }else{
                    if (date('d-M', strtotime($transaction->created_at)) == $condition) {
                        // dd(date('d-M', strtotime($sale->created_at)), $condition);
                        // increase sales in same day
                        $datasets['data'][$trans][$condition] += $transaction->total;

                        // increase sales by 1
                        $datasets['data']['total'][$condition] += 1;

                        // sale detail
                        $details = $transaction->details;
                        foreach ($details as $detail) {
                            $datasets['data']['product'][$condition] += $detail->quantity;
                            $total_trans = $detail->unit_price * $detail->quantity;
                            $datasets['data']['total_'.$trans] += $total_trans;
                        }
                    }
                }
            }
        }

        $average = $datasets['data']['total_'.$trans] / count($labels);
        $datasets['data']['average'] = round($average, 0);

        if ($show_report == 'monthly') {
            $datasets['data']['average_label'] = 'Rata-rata Transaksi Bulanan';
        }else{
            $datasets['data']['average_label'] = 'Rata-rata Transaksi Harian';
        }

        if (isset($datasets['data']) && count($datasets['data']) > 0) {
            $message = 'Laporan berhasil dibuat';
            $status = 'success';
        }else{
            $message = 'Laporan tidak ditemukan';
            $status = 'error';
        }

        return response()->json([
            'status'    => $status,
            'message'   => $message,
            'result'    => $datasets,
        ]);
    }


    private function getTrans($start_date, $end_date, $trans)
    {
        $start_date = date($start_date);
        $end_date = date($end_date);

        if ($trans == 'sales') {
            $data = Sales::whereHas('transaction', function ($query) {
                    $query->where('status', 'paid');
                })
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
        }else{
            $data = Purchase::whereHas('transaction', function ($query) {
                    $query->where('status', 'paid');
                })
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
        }
        return $data;
    }

    private function getProduct($start_date, $end_date, $product, $trans)
    {
        $start_date = date($start_date);
        $end_date = date($end_date);

        if ($trans = 'sales') {
            $data = Sales::whereHas('transaction', function ($query) {
                return $query->where('status', 'paid');
            })
            ->whereHas('details', function ($query) use ($product) {
                return $query->where('product_id', $product);
            })
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->get();
        }else{
            $data = Purchase::whereHas('transaction', function ($query) {
                return $query->where('status', 'paid');
            })
            ->whereHas('details', function ($query) use ($product) {
                return $query->where('product_id', $product);
            })
            ->whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->get();
        }


        return $data;
    }

    /**
     * Make labels for the chart.
     *
     * @param string $show_report The type of report to show daily|monthly.
     * @param string $start_date The start date of the report.
     * @param string $end_date The end date of the report.
     */
    private function makeLabels($show_report = 'daily', $start_date, $end_date)
    {
        $labels = [];

        if ($show_report == 'daily') {
            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date);
            $diff = $end_date - $start_date;
            $days = $diff / (60 * 60 * 24);
            for ($i = 0; $i <= $days; $i++) {
                $labels[] = date('d-M', strtotime("+$i day", $start_date));
            }
        } else {
            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date);
            $diff = $end_date - $start_date;
            $months = $diff / (60 * 60 * 24 * 30);
            for ($i = 0; $i <= $months; $i++) {
                $labels[] = date('M', strtotime("+$i month", $start_date));
            }
        }
        return $labels;
    }

    /**
     * print method.
     *
     */
    public function print(Request $request, $trans = 'sales')
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'report_type' => 'required|in:invoice,product',
            'show_report' => 'required|in:monthly,daily',
            'product' => 'sometimes|required_if:report_type,product',
        ]);
    }
}
