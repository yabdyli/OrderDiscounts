<?php

namespace App\Models;

class Order
{
	/**
	 * The products of the order
	 *
	 * @var array
	 */
	protected $products;

	/**
	 * The customer order
	 *
	 * @var integer
	 */
	protected $customer_id;

	/**
	 * The total of the order
	 *
	 * @var decimal
	 */
	protected $total;


	/**
	 * Create a new Order
	 *
	 * @param RegionInterface $region
	 * @return void
	 */
	public function __construct($customer_id)
	{
		$this->customer_id = $customer_id;
	}

	/**
	 * Add a product to the order
	 *
	 * @param string $sku
	 * @param integer $value
	 * @return boolean
	 */
	public function add($sku, $price,$description,$quantity,$category_id)
	{
	    $product = new Product(
	        $sku,
	        $price,
	        $description,
	        $quantity,
	        $category_id
	    );

	    $this->products[] = $product;

	    return true;
	}

	/**
	 * Add a product to the order
	 *
	 * @param array $orderData
	 * @param array $productData
	 * @return void
	 */
	public function insertProducts($orderData, $productData)
	{
		foreach($orderData->items as $product){

			$originalProduct = array_search($product->{'product-id'}, array_column($productData,'id'));
			
			$this->add(
						$product->{'product-id'},
						$product->{'unit-price'},
						$productData[$originalProduct]->description,
						$product->{'quantity'},
						$productData[$originalProduct]->category
					);
		}
	}

	/**
	 * Get the total parameter
	 *
	 * @return decimal
	 */
	public function getTotal()
	{
	    return $this->total;
	}

	/**
	 * Get the customer_id parameter
	 *
	 * @return integer
	 */
	public function getCustomer()
	{
	    return $this->customer_id;
	}

	/**
	 * Get the products parameter
	 *
	 * @return array
	 */
	public function getProducts()
	{
	    return $this->products;
	}
}