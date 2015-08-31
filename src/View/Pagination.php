<?php
namespace App\View;

class Pagination extends \Solution\View\View
{
	public function __construct($template = null)
	{
		$template = $template ? 
					$template :
					__DIR__."/../templates/pagination.tpl";
		parent::__construct($template);
	}
}