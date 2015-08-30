<?php
namespace App\Model;

class Product
{
	private $resource;

	public function __construct(\Solution\Api\Resource $productResource)
	{
		$this->resource = $productResource;
	}

	public function getTitle()
	{
		$title = $this->resource->get("title");
		return $title ? $title : "";
	}

	public function getPrice()
	{
		$price = $this->resource->get("price")->get('priceInVat');
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

	public function getDescription()
	{
		$description = $this->resource->get("content")->get("description");
		return $description ? $description : "";
	}
}