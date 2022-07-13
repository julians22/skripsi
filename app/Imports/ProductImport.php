<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToCollection
{
    public array $products;

    public function collection(Collection $rows)
    {
        $products = [];
        foreach ($rows as $key => $row) {
            if ($key > 0) {
                if (isset($row[0]) && isset($row[1])) {
                    $products[] = [
                        'code' => $row[0],
                        'name' => $row[1],
                        'price' => clear_number($row[2]),
                        'quantity' => $row[3],
                    ];
                }
            }
        }

        // sort products by name
        usort($products, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        $this->products = $products;
    }
}
