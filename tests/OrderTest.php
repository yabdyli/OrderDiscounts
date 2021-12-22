<?php

namespace Tests;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Discounts\DiscountLoyalCustomer;
use App\Discounts\DiscountProductByCategory;
use App\Discounts\DiscountCheapestProduct;
use PHPUnit\Framework\TestCase;


class OrderTest extends TestCase
{

	protected $product_inputs;

	protected $customer_inputs;

    protected function setUp(): void
    {
        $this->product_inputs = json_decode(file_get_contents('./data/products.json'));
        $this->customer_inputs = json_decode(file_get_contents('./data/customers.json'));
    }

	/** @test */
	function it_adds_new_order()
	{	
		$order_input = json_decode(file_get_contents(__DIR__.'/example-orders/order3.json'));

		$newOrder = new Order($order_input->{'customer-id'},$order_input->total);
		
		$newOrder->insertProducts($order_input, $this->product_inputs);
		
		$expectedTwoOrderProducts = 2;

		$this->assertCount(
			$expectedTwoOrderProducts,
			$newOrder->getProducts()
		);

	}

	/** @test */
	function it_rewards_loyal_customers()
	{	
		$order_input = json_decode(file_get_contents(__DIR__.'/example-orders/order2.json'));

		$newOrder = new Order($order_input->{'customer-id'},$order_input->total);
		
		$newOrder->insertProducts($order_input, $this->product_inputs);
		
		$originalCustomer = array_search($order_input->{'customer-id'}, array_column($this->customer_inputs,'id'));

		$customer = new Customer(
						$this->customer_inputs[$originalCustomer]->id,
						$this->customer_inputs[$originalCustomer]->name,
						$this->customer_inputs[$originalCustomer]->since,
						$this->customer_inputs[$originalCustomer]->revenue
					);

		$discountLoyalCustomer = (new DiscountLoyalCustomer($customer,2))->discount($newOrder);

		$expectedDiscount = 2.495;

		$this->assertEquals(
			$expectedDiscount,
			$discountLoyalCustomer
		);

	}

	/** @test */
	function it_increases_product_quantity_for_specific_category()
	{
	
		$order_input = json_decode(file_get_contents(__DIR__.'/example-orders/order1.json'));

		$newOrder = new Order($order_input->{'customer-id'},$order_input->total);
		
		$newOrder->insertProducts($order_input, $this->product_inputs);

		$originalCustomer = array_search($order_input->{'customer-id'}, array_column($this->customer_inputs,'id'));

		$customer = new Customer(
						$this->customer_inputs[$originalCustomer]->id,
						$this->customer_inputs[$originalCustomer]->name,
						$this->customer_inputs[$originalCustomer]->since,
						$this->customer_inputs[$originalCustomer]->revenue
					);

		$DiscountProductByCategory = (new DiscountProductByCategory($customer,2))->discount($newOrder);
		
		$expected = 12; // actual quantity in order1 is 10 so it should add 2 to quantity

		$this->assertEquals(
			$expected,
			$newOrder->getProducts()[0]->getQuantity()
		);
	}

	/** @test */
	function it_discounts_cheapest_product_in_order()
	{
		$order_input = json_decode(file_get_contents(__DIR__.'/example-orders/order3.json'));

		$newOrder = new Order($order_input->{'customer-id'},$order_input->total);

		$newOrder->insertProducts($order_input, $this->product_inputs);

		$originalCustomer = array_search($order_input->{'customer-id'}, array_column($this->customer_inputs,'id'));

		$customer = new Customer(
						$this->customer_inputs[$originalCustomer]->id,
						$this->customer_inputs[$originalCustomer]->name,
						$this->customer_inputs[$originalCustomer]->since,
						$this->customer_inputs[$originalCustomer]->revenue
					);

		$DiscountCheapestProduct = (new DiscountCheapestProduct($customer,1))->discount($newOrder);

		$this->assertEquals(3,$DiscountCheapestProduct);
	}

	/** @test */
	public function it_should_have_only_integer_quantity()
    {

        $order_input = json_decode(file_get_contents(__DIR__.'/example-orders/order3.json'));

        $newOrder = new Order($order_input->{'customer-id'},$order_input->total);

        $newOrder->insertProducts($order_input, $this->product_inputs);

        $firstproduct = $newOrder->getProducts()[0];

        $this->expectException(\Exception::class);

        $firstproduct->setQuantity("just some quantity");
        
    }
}