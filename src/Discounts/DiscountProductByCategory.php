<?php

namespace App\Discounts;

use App\Models\Customer;

class DiscountProductByCategory implements DiscountInterface
{
	/**
	 * The threshold to give free item
	 *
	 * @var integer
	 */ 
	private const DISCOUNT_EXTRA_ITEM = 5;

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

	public function __construct(Customer $customer,$discount_category)
	{
		$this->customer = $customer;
		$this->discount_category = $discount_category;
	}

	 /**
     * Give free product
     *
     * @var order
     */
	public function discount($order)
	{
		$updatedOrderProducts = array();

		foreach($order->getProducts() as $orderProduct)
		{
			if(
				$orderProduct->getQuantity() >= self::DISCOUNT_EXTRA_ITEM && 
				$orderProduct->getCategory() == $this->discount_category
				)
			{
				$new_quantity = $orderProduct->getQuantity() + floor($orderProduct->getQuantity() / self::DISCOUNT_EXTRA_ITEM);
				
				$orderProduct->setQuantity((int) $new_quantity);
				
				$updatedOrderProducts[] = $orderProduct;

				$order->setDiscount("You get ".floor($orderProduct->getQuantity() / self::DISCOUNT_EXTRA_ITEM)." items free of charge for Product: ".$orderProduct->getSku());
			}
		}

		$order->updateProductsQuantity($updatedOrderProducts);

	}

}