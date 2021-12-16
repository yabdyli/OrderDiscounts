<?php

namespace App\Models;

use JsonSerializable;

class Order implements JsonSerializable
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
	 * The discount_messages of the order
	 *
	 * @var array
	 */
	protected $discount_messages;

	/**
	 * Create a new Order
	 *
	 * @param integer $customer_id
	 * @return void
	 */
	public function __construct($customer_id,$total)
	{
		$this->customer_id = $customer_id;
		$this->total = $total;
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
	 * Update Order products
	 *
	 * @param array $products
	 * @return void
	 */
	public function updateProductsQuantity($products)
	{
		foreach($products as $product){

			$_orderproduct = array_search($product->getSku(), array_column($this->products,'sku'));
			
			$this->products[$_orderproduct]->setQuantity($product->getQuantity());
		}
	}

	/**
	 * Get the newTotal parameter
	 *
	 * @return decimal
	 */
	public function updateTotal($newTotal)
	{
	     $this->total = $newTotal;
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

	/**
	 * Set discount_messages
	 *
	 * @return void
	 */
	public function setDiscount($discount_message)
	{
	    $this->discount_messages[] = $discount_message;
	}

	/**
	 * Get the discount_messages parameter
	 *
	 * @return array
	 */
	public function getDiscounts()
	{
	    return $this->discount_messages;
	}

	/**
	 * Serialize the Order object to Json
	 *
	 * @return mixed
	 */
	public function jsonSerialize(): mixed
	{
        return [
            'customer_id' => $this->customer_id,
            'items' => $this->products,
            'discounts' => $this->discount_messages,
            'total'	  => (string)$this->total
        ]; 
    }

}