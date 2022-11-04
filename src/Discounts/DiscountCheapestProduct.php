<?php

namespace App\Discounts;

use App\Models\Customer;

class DiscountCheapestProduct implements DiscountInterface
{
    /**
     * The threshold to give discount
     *
     * @var integer
     */
    private const DISCOUNT_ITEM_THRESHOLD = 2;

    /**
     * The discount percentage
     *
     * @var integer
     */
    private const DISCOUNT_PERCENTAGE = 0.2;

    /**
     * The category for discount
     *
     * @var integer
     */
    protected $discount_category;

    /**
     * Customer
     *
     * @var Customer
     */
    protected Customer $customer;

    public function __construct(Customer $customer, $discount_category)
    {
        $this->customer = $customer;
        $this->discount_category = $discount_category;
    }

    /**
    * Give discount on cheapest product
    *
    * @var order
    */
    public function discount($order)
    {
        $category = $this->discount_category;

        $filterProducts = array_filter($order->getProducts(), function ($element) use ($category) {
            return ($element->getCategory() == $category);
        });

        $totalQuantitySum = array_reduce($filterProducts, function ($carry, $item) {
            return $carry + $item->getQuantity();
        });
        if ($totalQuantitySum >= self::DISCOUNT_ITEM_THRESHOLD) {
            $cheapest_product =  min(array_map(
                function ($o) {
                return $o->price;
            },
                $filterProducts
            ));

            $_discount = (float) number_format($cheapest_product *  self::DISCOUNT_PERCENTAGE);

            if ($_discount>0) {
                $current_total = $order->getTotal();
                $current_total -= $_discount;

                $order->updateTotal($current_total);
            }

            $order->setDiscount("Cheapest Product: You pay 20% less for cheapest product");
        }

        return $totalQuantitySum;
    }
}
