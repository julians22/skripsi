<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'report_type' => 'required|in:sales,product',
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


        if ($report_type == 'sales'){
            $sales = $this->getSales($start_date, $end_date);
        }else{
            $sales = $this->getProduct($start_date, $end_date, $product);
        }

        $labels = $this->makeLabels($show_report, $start_date, $end_date);

        $datasets = [
            'label' => 'Sales',
            'data' => []
        ];

        // make sales data
        $datasets['data']['total_sale'] = 0;
        $datasets['data']['average'] = 0;
        foreach ($labels as $label) {
            // convert Month to number
            $condition = $label;

            $datasets['data']['sales'][$condition] = 0;
            $datasets['data']['total'][$condition] = 0;
            $datasets['data']['product'][$condition] = 0;
            // group sales by month or day
            foreach ($sales as $sale) {
                // increase total sales
                if ($show_report == 'monthly') {
                    if (date('M', strtotime($sale->created_at)) == $condition) {
                        // increase sales in same condition
                        $datasets['data']['sales'][$condition] += $sale->total;
                        // increase sales by 1
                        $datasets['data']['total'][$condition] += 1;

                        $datasets['data']['total_sale'] += $sale->total;
                        // sale detail
                        $details = $sale->details;
                        foreach ($details as $detail) {
                            $datasets['data']['product'][$condition] += $detail->quantity;
                        }
                    }
                }else{
                    if (date('d-M', strtotime($sale->created_at)) == $condition) {
                        // dd(date('d-M', strtotime($sale->created_at)), $condition);
                        // increase sales in same day
                        $datasets['data']['sales'][$condition] += $sale->total;

                        // increase sales by 1
                        $datasets['data']['total'][$condition] += 1;

                        // sale detail
                        $details = $sale->details;
                        foreach ($details as $detail) {
                            $datasets['data']['product'][$condition] += $detail->quantity;
                            $total_sale = $detail->unit_price * $detail->quantity;
                            $datasets['data']['total_sale'] += $total_sale;
                        }
                    }
                }
            }
        }
        $average = $datasets['data']['total_sale'] / count($labels);
        $datasets['data']['average'] = round($average, 0);

        if ($show_report == 'monthly') {
            $datasets['data']['average_label'] = 'Rata-rata penjualan Bulanan';
        }else{
            $datasets['data']['average_label'] = 'Rata-rata penjualan Harian';
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


    private function getSales($start_date, $end_date)
    {
        $start_date = date($start_date);
        $end_date = date($end_date);

        $sales = Sales::whereHas('transaction', function ($query) {
                $query->where('status', 'paid');
            })
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();
        return $sales;
    }

    private function getProduct($start_date, $end_date, $product)
    {
        $start_date = date($start_date);
        $end_date = date($end_date);

        $sales = Sales::whereHas('transaction', function ($query) {
            return $query->where('status', 'paid');
        })
        ->whereHas('details', function ($query) use ($product) {
            return $query->where('product_id', $product);
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->get();

        return $sales;
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
}
