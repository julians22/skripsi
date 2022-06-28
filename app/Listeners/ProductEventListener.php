<?php

namespace App\Listeners;

use App\Events\Backend\Products\ProductCreated;
use App\Events\Products\ProductUpdated;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductEventListener
{

    /**
     * Product onCreated event listener.
     * @param $event
     */
    public function onCreated($event)
    {
        activity('product')
            ->performedOn($event->product)
            ->withProperties([
                'product' => [
                    'name' => $event->product->name,
                    'description' => $event->product->description,
                    'price' => $event->product->price,
                    'quantity' => $event->product->quantity,
                ],
            ])
            ->log(':causer.name created product :subject.name');
    }

    /**
     * Product onUpdated event listener.
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('product')
            ->performedOn($event->product)
            ->withProperties([
                'product' => [
                    'name' => $event->product->name,
                    'description' => $event->product->description,
                    'price' => $event->product->price,
                    'quantity' => $event->product->quantity,
                ],
            ])
            ->log(':causer.name updated product :subject.name');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            ProductCreated::class,
            [ProductEventListener::class, 'onCreated']
        );

        $events->listen(
            ProductUpdated::class,
            [ProductEventListener::class, 'onUpdated']
        );
    }


}
