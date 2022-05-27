<?php

namespace App\Services\Transactions;

use App\Models\Transaction;
use App\Services\BaseService;

class TransactionServices extends BaseService
{
    /**
     * TransactionServices constructor.
     *
     *
     * @param Transaction $transaction Transaction Model
     **/
    public function __construct(Transaction $transaction)
    {
        $this->model = $transaction;
    }

    public function getByMonth(int $month = 0, int $year = 0)
    {
        return $this->model::MonthInYear($month, $year)->get();
    }

    public function getToday()
    {
        return $this->model::Today()->get();
    }
}

?>
