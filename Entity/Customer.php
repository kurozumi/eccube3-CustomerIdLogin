<?php
namespace Plugin\CustomerIdLogin\Entity;

use Eccube\Entity\Customer as BaseCustomer;
/**
 * Customer
 *
 *  @UniqueEntity("email")
 */
class Customer extends BaseCustomer
{
}
