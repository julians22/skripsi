<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\Sales;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchases = Purchase::all();
        $sales = Sales::all();

        foreach ($purchases as $purchase) {
            $purchase->transaction()->create([
                'code' => 'PUR-' . Uuid::uuid4()->toString(),
                'status' => 'paid',
                'total' => $purchase->total,
            ]);
        }

        foreach ($sales as $sale) {
            $sale->transaction()->create([
                'code' => 'SAL-' . Uuid::uuid4()->toString(),
                'status' => 'paid',
                'total' => $sale->total,
            ]);
        }
    }
}
