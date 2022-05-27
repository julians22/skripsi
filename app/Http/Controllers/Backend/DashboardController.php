<?php

namespace App\Http\Controllers\Backend;

use App\Services\Transactions\TransactionServices;

/**
 * Class DashboardController.
 */
class DashboardController
{
    protected $transactionServices;

    /**
     * DashboardController constructor.
     *
     * @param TransactionServices $transactionServices
     */
    public function __construct(TransactionServices $transactionServices)
    {
        $this->transactionServices = $transactionServices;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $currentMonthTransactions = $this->transactionServices->getByMonth(date('m'), date('Y'));
        $sellingThisMonth = 0;
        foreach ($currentMonthTransactions as $transaction) {
            $sellingThisMonth += $transaction->total;
        }

        $lastMonthTransactions = $this->transactionServices->getByMonth(date('m') - 1, date('Y'));
        $sellingLastMonth = 0;
        foreach ($lastMonthTransactions as $transaction) {
            $sellingLastMonth += $transaction->total;
        }

        $todayTransactions = $this->transactionServices->getToday();
        $sellingToday = 0;
        foreach ($todayTransactions as $transaction) {
            $sellingToday += $transaction->total;
        }

        $contents = [
            'selling_this_month' => number_format($sellingThisMonth, 0, ',', '.'),
            'selling_last_month' => number_format($sellingLastMonth, 0, ',', '.'),
            'selling_today' => number_format($sellingToday, 0, ',', '.'),
        ];

        return view('backend.dashboard', compact('contents'));
    }
}
