<?php
// features/bootstrap/Basket.php

final class Basket
{
    private $products;
    private $productPrice = 0.0;
    private $shelf;


    public function __construct(Shelf $shelf)
    {
        $this->shelf = $shelf;
    }

    public function addProduct($product) {
        $this->products[] = $product;
        $this->productPrice[] += $this->shelf->getProductPrice($product);
    }


}