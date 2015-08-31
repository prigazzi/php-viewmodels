<?php
namespace App\View\Component\Price;

class Model
{
    private $resource;

    public function __construct(\Solution\Api\Resource $priceResource)
    {
        $this->resource = $priceResource;
    }

    public function getPrice()
    {
        $price = $this->resource->get('priceInVat');
        return $price ? $price : '';
    }

    public function getPriceWithoutVat()
    {
        $price = $this->getPrice();

        if (is_float($price)) {
            return $price * 1.2;
        }

        return "";
    }
}
