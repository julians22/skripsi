<?php

namespace App\Http\Controllers\Backend;

use App\Exports\Report\SalesReport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $productHasTransactions = SalesDetail::select('product_id')
            ->with('product')
            ->groupBy('product_id')
            ->get();

        return view('backend.report.index', [
            'products' => $productHasTransactions,
        ]);
    }

    public function sales(Request $request)
    {
        $validate = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        return (new SalesReport($validate['start_date'], $validate['end_date']))->download('sales.xlsx');
    }
}
