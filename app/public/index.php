<?php
use Solution\View\Factory;

include __DIR__ . '/../../vendor/autoload.php';

$factory = new Factory();
$factory->param('App.View.SearchPage.template', __DIR__.'/../templates/searchpage.tpl');
$factory->param('App.View.SearchResults.template', __DIR__.'/../templates/searchresults.tpl');
$factory->singleton("App.View.SearchPage", function() {
	return new \App\View\SearchPage($this->param('App.View.SearchPage.template'));
});
$factory->singleton("App.View.SearchResults", function() {
	return new \App\View\SearchResults($this->param('App.View.SearchResults.template'));
	
});

$searchPageView = $factory->get('App.View.SearchPage');
$searchPageView->title = "Search Results";

$searchResults = $factory->get('App.View.SearchResults');
$searchPageView->attachView('results', $searchResults);

echo $searchPageView->parse();