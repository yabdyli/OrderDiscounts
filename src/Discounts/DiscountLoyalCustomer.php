<?php

namespace App\Discounts;

use App\Models\Customer;

class DiscountLoyalCustomer implements DiscountInterface
{
    private const DISCOUNT_REVENUE = 1000;
    private const DISCOUNT_LOYAL = 0.1;

    /**
     * Customer
     *
     * @var Customer
     */
    protected Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
    * Discount order for loyal customers
    *
    * @var order
    */
    public function discount($order)
    {
        $discount_percentage = 0;

        if ($this->customer->revenue >= self::DISCOUNT_REVENUE) {
            $discount_percentage = $order->getTotal() * self::DISCOUNT_LOYAL;

            if ($discount_percentage>0) {
                $current_total = $order->getTotal();
                $current_total -= $discount_percentage;

                $order->updateTotal($current_total);
            }

            $order->setDiscount("Loyal discount: You pay 10% less for the entire order");
        }

        return $discount_percentage;
    }
}
