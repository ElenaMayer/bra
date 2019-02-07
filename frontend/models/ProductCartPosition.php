<?php
/**
 * Created by PhpStorm.
 * User: elenam
 * Date: 13.12.17
 * Time: 14:37
 */

namespace frontend\models;

use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CostCalculationEvent;
use common\models\Product;


class ProductCartPosition implements CartPositionInterface
{
    /**
     * @var Product
     */
    protected $_product;
    protected $_quantity;

    public $id;
    public $price;
    public $size;

    public function getId()
    {
        return md5(serialize([$this->id, $this->size]));
    }

    public function getPrice()
    {
        $product = $this->getProduct();
        if(!$product->is_in_stock || !$product->is_active)
            return 0;
        else
            return $product->getPrice();
    }

    public function getSize()
    {
        return $this->getProduct()->size;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if ($this->_product === null) {
            $this->_product = Product::findOne($this->id);
        }
        return $this->_product;
    }

    public function getQuantity()
    {
        return $this->_quantity;
    }

    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;
    }

    /**
     * Default implementation for getCost function. Cost is calculated as price * quantity
     * @param bool $withDiscount
     * @return int
     */
    public function getCost($withDiscount = true)
    {
        /** @var Component|CartPositionInterface|self $this */
        $cost = $this->getQuantity() * $this->getPrice();
        $costEvent = new CostCalculationEvent([
            'baseCost' => $cost,
        ]);
        if ($this instanceof Component)
            $this->trigger(CartPositionInterface::EVENT_COST_CALCULATION, $costEvent);
        if ($withDiscount)
            $cost = max(0, $cost - $costEvent->discountValue);
        return $cost;
    }
}