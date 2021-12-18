<?php

namespace App\Models;

use JsonSerializable;

class Product implements JsonSerializable
{
	/**
	 * The product's stock keeping unit
	 *
	 * @var string
	 */
	protected $sku;

	/**
	 * The price of the product
	 *
	 * @var decimal
	 */
	public $price;

	/**
	 * The category of product
	 *
	 * @var integer
	 */
	protected $category_id;

	/**
	 * The description of the current product
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * The quantity of the current product
	 *
	 * @var int
	 */
	protected $quantity;

	/**
	 * Construct
	 *
	 * @param string $sku
	 * @param decimal $price
	 * @param int $category_id
	 * @param string $description
	 * @return void
	 */
	public function __construct($sku, $price, $description = '', $quantity = 1,$category_id = false)
	{
	    $this->sku = $sku;
	    $this->price = $price;
	    $this->description = $description;
	    $this->quantity = $quantity;

	    if($category_id)
	    	$this->category_id = $category_id;
	}

	/**
	 * Set the category_id parameter
	 *
	 * @param integer $value
	 * @return void
	 */
	public function setCategory($value)
	{
	    if (is_int($value)) 
	    {
	        $this->category_id = $value;
	    }else
	    {
	    	 throw new InvalidArgumentException('It only accepts integers. Input was: '.$value);
	    }
	}

	/**
	 * Set the description parameter
	 *
	 * @param string $value
	 * @return void
	 */
	public function setDescription($value)
	{
	    $this->description = $value;
	}

	/**
	 * Set the quantity parameter
	 *
	 * @param integer $value
	 * @return void
	 */
	public function setQuantity($value)
	{
	    if (is_int($value)) 
	    {
	        $this->quantity = $value;
	    }else
	    {
	    	 throw new InvalidArgumentException('It only accepts integers. Input was: '.$value);
	    }
	}

	/**
	 * Get the quantity parameter
	 *
	 * @return integer
	 */
	public function getQuantity()
	{
	    return $this->quantity;
	}

	/**
	 * Get the sku parameter
	 *
	 * @return integer
	 */
	public function getSku()
	{
	    return $this->sku;
	}

	/**
	 * Get the category parameter
	 *
	 * @return integer
	 */
	public function getCategory()
	{
	    return $this->category_id;
	}

	/**
	 * Serialize the Product object to Json
	 *
	 * @return mixed
	 */
	public function jsonSerialize(): mixed
	{
        return [
            'sku' => $this->sku,
            'quantity' => (string) $this->quantity,
            'price' => $this->price,
            'category_id'	  => $this->category_id,
            'description' => $this->description

        ]; 
    }
}