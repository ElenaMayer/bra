<?php

namespace frontend\models;

use yz\shoppingcart\ShoppingCart;

class MyShoppingCart extends ShoppingCart
{

    /**
     * @return int
     */
    public function getActiveCount()
    {
        $count = 0;
        foreach ($this->_positions as $position)
            $count += $position->getActiveQuantity();
        return $count;
    }
}