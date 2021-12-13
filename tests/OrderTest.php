<?php

namespace Tests;

use App\Models\Order;
use App\Models\Product;
use PHPUnit\Framework\TestCase;


class OrderTest extends TestCase
{

	/** @test */
	function it_adds_new_order()
	{
		
		$order_input = json_decode(file_get_contents('./example-orders/order3.json'));

		$product_inputs = json_decode(file_get_contents('./data/products.json'));

		$newOrder = new Order($order_input->{'customer-id'});
		
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
}