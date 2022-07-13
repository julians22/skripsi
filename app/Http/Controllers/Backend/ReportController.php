<?php

namespace App\Http\Controllers\Backend;

use App\Exports\Report\SalesReport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseDetail;
use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $productHasTransactionsInSales = SalesDetail::select('product_id')
            ->with('product')
            ->groupBy('product_id')
            ->get();

        $productHasTransactionsInPurchase = PurchaseDetail::select('product_id')
            ->with('product')
            ->groupBy('product_id')
            ->get();

        return view('backend.report.index', [
            'sales_products' => $productHasTransactionsInSales,
            'purchase_products' => $productHasTransactionsInPurchase,
        ]);
    }
}
