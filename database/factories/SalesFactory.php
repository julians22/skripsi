<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Sales;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sales::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $customer_id = array_rand([1,3,4]);
        return [
            'customer_id' => $customer_id,
            'invoice_number' => $this->faker->unique()->randomNumber(6),
            'total' => $this->faker->randomFloat(2, 0, 100),
            'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
