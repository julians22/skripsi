<?php

namespace App\Services\Transactions;

use App\Models\Purchase;
use App\Services\BaseService;

class PurchaseServices extends BaseService
{
    /**
     * PurchaseServices constructor.
     *
     * @param Purchase $purchase Purchase Model
     */

    public function __construct(Purchase $purchase){
        $this->model = $purchase;
    }

    /**
     * Get by month
     */
    public function getByMonth(int $month = 0, int $year = 0)
    {
        return $this->model::MonthInYear($month, $year)->get();
    }

    public function getToday()
    {
        return $this->model::Today()->get();
    }

    public function getAllPaginated(int $paginate = 10)
    {
        return $this->model::paginate($paginate);
    }

    /**
     * Get all purchases with defined column.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getForEvent()
    {
        return $this->model::with('supplier', 'transaction')->get();
    }
}
