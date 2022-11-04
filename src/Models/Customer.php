<?php

namespace App\Models;

class Customer
{
    /**
     * The customer id
     *
     * @var integer
     */
    public $customer_id;

    /**
     * The Customer name
     *
     * @var string
     */
    public $name;

    /**
     * The date customer registered
     *
     * @var date
     */
    public $since;

    /**
     * The customer revenue
     *
     * @var decimal
     */
    public $revenue;

    /**
     * Create a new Customer
     *
     * @param integer $customer_id
     * @param string $name
     * @param date $since
     * @param decimal $revenue
     * @return void
     */
    public function __construct($customer_id, $name, $since, $revenue)
    {
        $this->customer_id = $customer_id;
        $this->name = $name;
        $this->since = $since;
        $this->revenue = $revenue;
    }
}
