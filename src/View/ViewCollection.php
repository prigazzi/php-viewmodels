<?php
namespace Solution\View;

class ViewCollection
{
	private $views = null;

	public function __construct(\Traversable $view)
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