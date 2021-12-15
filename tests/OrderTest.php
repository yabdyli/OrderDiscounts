<?php

namespace Tests;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Discounts\DiscountProductByCategory;
use PHPUnit\Framework\TestCase;


class OrderTest extends TestCase
{

	/** @test */
	function it_adds_new_order()
	{
		
		$order_input = json_decode(file_get_contents('./example-orders/order3.json'));

		$product_inputs = json_decode(file_get_contents('./data/products.json'));

		$customer_inputs = json_decode(file_get_contents('./data/customers.json'));

		$newOrder = new Order($order_input->{'customer-id'},$order_input->total);
		
		foreach($order_input->items as $product){

			$original_product = array_search($product->{'product-id'}, array_column($product_inputs,'id'));
			
			$newOrder->add(
						$product->{'product-id'},
						$product->{'unit-price'},
						$product_inputs[$original_product]->description,
						$product->{'quantity'},
						$product_inputs[$original_product]->category
					);
		}

		
		$this->assertEquals(
			2,
			count($newOrder->getProducts())
		);

	}

	/** @test */
	function it_increases_product_quantity_for_specific_category(){
	
		$order_input = json_decode(file_get_contents('./example-orders/order2.json'));

		$product_inputs = json_decode(file_get_contents('./data/products.json'));

		$customer_inputs = json_decode(file_get_contents('./data/customers.json'));

		$newOrder = new Order($order_input->{'customer-id'},$order_input->total);
		
		$newOrder->insertProducts($order_input, $product_inputs);

		$originalCustomer = array_search($order_input->{'customer-id'}, array_column($customer_inputs,'id'));

		$customer = new Customer(
						$customer_inputs[$originalCustomer]->id,
						$customer_inputs[$originalCustomer]->name,
						$customer_inputs[$originalCustomer]->since,
						$customer_inputs[$originalCustomer]->revenue
					);

		$DiscountProductByCategory = (new DiscountProductByCategory($customer,2))->discount($newOrder);
		
		
		$this->assertEquals(
			6,
			$newOrder->getProducts()[0]->getQuantity()
		);
	}
}