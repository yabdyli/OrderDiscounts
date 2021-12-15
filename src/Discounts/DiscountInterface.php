<?php

namespace App\Discounts;

interface DiscountInterface
{
    /**
     * Discount for order
     *
     * @var order
     */
    public function discount($order);
}