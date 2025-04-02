<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    private function updateStats()
    {
        $stats = [
            'campaign' => Product::where('is_campaign', true)->count(),
            'gift' => Product::where('has_gift', true)->count(),
            'showcase' => Product::where('is_showcase', true)->count(),
            'bestseller' => Product::where('is_bestseller', true)->count(),
            'new' => Product::where('is_new', true)->count(),
            'counter' => Product::where('has_counter', true)->count(),
            'discount' => Product::where('has_discount_stock', true)->count(),
            'passive' => Product::where('is_passive', true)->count(),
            'closed' => Product::where('is_closed', true)->count(),
        ];

        Cache::forever('product_stats', $stats);
    }

    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $this->updateStats();
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $this->updateStats();
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $this->updateStats();
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        $this->updateStats();
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        $this->updateStats();
    }
}
