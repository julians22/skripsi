<?php

namespace App\Services\Transactions;

use App\Models\Sales;
use App\Services\BaseService;

class SalesServices extends BaseService
{
    /**
     * SalesServices constructor.
     *
     *
     * @param Sales $sales Sales Model
     **/
    public function __construct(Sales $sales)
    {
        $this->model = $sales;
    }

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
        return $this->model::with('customer', 'transaction')->paginate($paginate);
    }
}

?>
