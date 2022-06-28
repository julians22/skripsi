<?php

namespace App\Services;

use App\Models\Product;
use App\Services\BaseService;

class ProductServices extends BaseService
{
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAllPaginated(int $page = 10)
    {
        return $this->model->paginate($page);
    }
}
