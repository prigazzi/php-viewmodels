<?php
namespace Solution\View;

class ViewCollection extends View
{
	private $views = null;

	public function __construct(\Traversable $views)
	{
		$this->views = $views;
	}

	public function parse()
	{
		$output = "";

		foreach ($this->views as $view) {
			$output.= $view->parse();
		}

		return $output;
	}
}