<?php
// features/bootstrap/Shelf.php

final class User
{
    //private $priceMap = array();
    private $username;

    public function setUsername($name) {
        $this->username = $name;
    }

    public function getUsername() {
        return $this->username;
    }
}