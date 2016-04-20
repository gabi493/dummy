<?php
// features/bootstrap/Basket.php

final class Basket implements \Countable
{
    private $products;
    private $productsPrice = 0.0;
    private $shelf;

    private function vat($price) {
        return $price * 0.2;
    }
    private function deliveryCost($price) {
        return ($price > 10 ? 2.0 : 3.0);
    }


    public function __construct(Shelf $shelf)
    {
        $this->shelf = $shelf;
    }

    public function addProduct($product) {
        $this->products[] = $product;
        $this->productsPrice += $this->shelf->getProductPrice($product);
    }

    public function getTotalPrice() {
        return $this->productsPrice
        + $this->vat($this->productsPrice)
        + $this->deliveryCost($this->productsPrice);
    }

    public function count()
    {
        return count($this->products);
    }
}