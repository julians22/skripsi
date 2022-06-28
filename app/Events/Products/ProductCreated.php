<?php

namespace App\Events\Products;

use App\Models\Product;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class ProductCreated
{
    use SerializesModels;

    // product properties
    public $product;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
}
