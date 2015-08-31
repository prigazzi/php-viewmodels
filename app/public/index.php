<?php
use Solution\View\Factory;

include __DIR__ . '/../../vendor/autoload.php';
    
$factory = new Factory();
// $factory->param('App.View.SearchPage.template', __DIR__.'/../templates/searchpage.tpl');
// $factory->param('App.View.Product.template', __DIR__.'/../templates/product.tpl');

// $factory->singleton("App.View.SearchPage", function () {
//     return new \Solution\View\View($this->param('App.View.SearchPage.template'));
// });
// $factory->singleton('App.View.Pagination', function () {
//     return new \App\View\Pagination();
// });
// $factory->factory('App.View.Product', function ($productModel) {
//     return new \App\View\Product($this->param('App.View.Product.template'), $productModel);
// });
// $factory->factory("App.View.SearchResults", function (\Traversable $resourceCollection) {
//     foreach ($resourceCollection as $productResource) {
//         $productModel = new \App\Model\Product($productResource);
//         $view = $this->get('App.View.Product', $productModel);

//         yield $view;
//     }
// });

// // Example on how to instantiate new views
// $searchPageView = $factory->get('App.View.SearchPage');
// $searchPageView->title = "Search Results";

// // Example on simply attaching subViews into parentViews
// $paginationView = $factory->get('App.View.Pagination');
// $searchPageView->attachView('pagination', $paginationView);

// // Example on loading several Views into a Collection
// $searchResults = $factory->get('App.View.SearchResults', \Solution\Api\ResourceGenerator::createProductResource());
// $searchPageView->attachView('results', $searchResults);

// echo $searchPageView->parse();

//// ------

$factory->param('App.View.Component.Product.template', __DIR__."/../../src/View/Component/Product/template.tpl");
$factory->param('App.View.Component.Price.template', __DIR__."/../../src/View/Component/Price/template.tpl");

// How to create a Product
$factory->factory('App.View.Component.Product.View', function ($productResource) {
    $model = new \App\View\Component\Product\Model($productResource);
    return new \App\View\Component\Product\View($this->param('App.View.Component.Product.template'), $model);
});

// How to create a Price
$factory->factory('App.View.Component.Price.View', function ($priceResource) {
    $model = new \App\View\Component\Price\Model($priceResource);
    return new \App\View\Component\Price\View($this->param('App.View.Component.Price.template'), $model);
});

// How to combine Product and Price on a Search Result
$factory->factory('App.View.SearchResults', function ($productResources) {
    foreach ($productResources as $productResource) {
        $view = $this->get('App.View.Component.Product.View', $productResource);
        $view->attachView('price', $this->get('App.View.Component.Price.View', $productResource->get('price')));
        
        yield $view;
    }
});

$traversable = $factory->get('App.View.SearchResults', \Solution\Api\ResourceGenerator::createProductResource());
$view = new \Solution\View\ViewCollection($traversable);

echo $view->parse();
