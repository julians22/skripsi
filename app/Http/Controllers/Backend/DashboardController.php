<?php

namespace App\Http\Controllers\Backend;

use App\Services\Transactions\PurchaseServices;
use App\Services\Transactions\SalesServices;

/**
 * Class DashboardController.
 */
class DashboardController
{
    protected $salesServices;
    protected $purchaseServices;

    /**
     * DashboardController constructor.
     *
     * @param SalesServices $salesServices
     * @param PurchaseServices $purchaseServices
     */
    public function __construct(SalesServices $salesServices, PurchaseServices $purchaseServices)
    {
        $this->salesServices = $salesServices;
        $this->purchaseServices = $purchaseServices;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $currentMonthSales = $this->salesServices->getByMonth(date('m'), date('Y'));
        $sellingThisMonth = 0;
        foreach ($currentMonthSales as $sale) {
            $sellingThisMonth += $sale->total;
        }

        $lastMonthSales = $this->salesServices->getByMonth(date('m') - 1, date('Y'));
        $sellingLastMonth = 0;
        foreach ($lastMonthSales as $sale) {
            $sellingLastMonth += $sale->total;
        }

        $todaySales = $this->salesServices->getToday();
        $sellingToday = 0;
        foreach ($todaySales as $sale) {
            $sellingToday += $sale->total;
        }

        $currentMonthPurchase = $this->purchaseServices->getByMonth(date('m'), date('Y'));
        $purchasingThisMonth = 0;
        foreach ($currentMonthPurchase as $purchase) {
            $purchasingThisMonth += $purchase->total;
        }

        $lastMonthPurchase = $this->purchaseServices->getByMonth(date('m') - 1, date('Y'));
        $purchasingLastMonth = 0;
        foreach ($lastMonthPurchase as $purchase) {
            $purchasingLastMonth += $purchase->total;
        }

        $todayPurchase = $this->purchaseServices->getToday();
        $purchasingToday = 0;
        foreach ($todayPurchase as $purchase) {
            $purchasingToday += $purchase->total;
        }

        $saleEvents = $this->salesServices->getForEvent();
        $purchaseEvents = $this->purchaseServices->getForEvent();

        $contents = [
            'selling_this_month' => number_format($sellingThisMonth, 0, ',', '.'),
            'selling_last_month' => number_format($sellingLastMonth, 0, ',', '.'),
            'selling_today' => number_format($sellingToday, 0, ',', '.'),
            'purchasing_this_month' => number_format($purchasingThisMonth, 0, ',', '.'),
            'purchasing_last_month' => number_format($purchasingLastMonth, 0, ',', '.'),
            'purchasing_today' => number_format($purchasingToday, 0, ',', '.'),
            'sale_events' => $saleEvents,
            'purchase_events' => $purchaseEvents,
        ];

        return view('backend.dashboard', compact('contents'));
    }
}
