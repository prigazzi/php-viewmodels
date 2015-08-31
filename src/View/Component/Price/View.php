<?php
namespace App\View\Component\Price;

use Solution\View\View as BaseView;

class View extends BaseView
{
    private $model;

    public function __construct($template, Model $price)
    {
        parent::__construct($template);
        $this->model = $price;
    }

    public function parse()
    {
        $this->price = $this->model->getPrice();

        return parent::parse();
    }
}
