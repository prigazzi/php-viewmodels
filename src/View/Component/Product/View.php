<?php
namespace App\View\Component\Product;

use Solution\View\View as BaseView;

class View extends BaseView
{
    private $model;

    public function __construct($template, Model $product)
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
