<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->word;
        $code = $this->faker->unique()->randomNumber(6);
        return [
            'name' => $name,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'slug' => Str::slug($name),
            'category_id' => 1,
            'code' => 'AR-'.$code,
        ];
    }
}
