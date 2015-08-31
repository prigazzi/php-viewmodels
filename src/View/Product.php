<?php
namespace App\View;

use Solution\View\View; 

class Product extends View
{
	private $model;

	public function __construct($template, \App\Model\Product $product)
	{
		parent::__construct($template);
		$this->model = $product;
	}

	public function parse()
	{
		$this->title = $this->model->getTitle();
		$this->price = $this->model->getPrice();
		$this->description = $this->model->getDescription();

		return parent::parse();
	}
}