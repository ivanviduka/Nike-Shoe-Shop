<?php

class Shoes
{
    public function __construct($shoe_name, $price, $imgURL)
    {
        $this->id = "id-" . round(microtime(true) * 1000);
        $this->shoe_name = $shoe_name;
        $this->price = $price;
        $this->imgURL = $imgURL;
    }
}

