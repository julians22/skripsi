<?php

namespace App\Services\Transactions;

use App\Models\Sales;
use App\Services\BaseService;
use DB;

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

    /**
     * Get all sales with defined column.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getForEvent(array $columns = ['created_at'])
    {
        $relationsColumn = ['customer', 'transaction'];
        $columns = array_merge($columns, $relationsColumn);
        return $this->model::with('customer', 'transaction')->get();
    }

    public function takeLastRow()
    {
        return DB::table('sales')->orderBy('id', 'desc')->first();
    }
}

?>
