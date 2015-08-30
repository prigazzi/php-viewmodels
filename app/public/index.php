<?php
use Solution\View\Factory;

include __DIR__ . '/../../vendor/autoload.php';

$factory = new Factory();
$factory->param('App.View.SearchPage.template', __DIR__.'/../templates/searchpage.tpl');
$factory->param('App.View.Product.template', __DIR__.'/../templates/product.tpl');

$factory->singleton("App.View.SearchPage", function() {
	return new \Solution\View\View($this->param('App.View.SearchPage.template'));
});
$factory->singleton('App.View.Pagination', function() {
	return new \App\View\Pagination();
});
$factory->factory('App.View.Product', function($productModel) {
	return new \App\View\Product($this->param('App.View.Product.template'), $productModel);
});
$factory->factory("App.View.SearchResults", function(\Traversable $resourceCollection) {
	foreach ($resourceCollection as $productResource) {
		$productModel = new \App\Model\Product($productResource);
		$view = $this->get('App.View.Product', $productModel);

		yield $view;
	}
});

// Example on how to instantiate new views
$searchPageView = $factory->get('App.View.SearchPage');
$searchPageView->title = "Search Results";

// Example on simply attaching subViews into parentViews
$paginationView = $factory->get('App.View.Pagination');
$searchPageView->attachView('pagination', $paginationView);

// Example on loading several Views into a Collection
$searchResults = $factory->get('App.View.SearchResults', \Solution\Api\ResourceGenerator::createProductResource());
$searchPageView->attachView('results', $searchResults);

echo $searchPageView->parse();