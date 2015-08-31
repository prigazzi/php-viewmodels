<?php
namespace Solution\Api;

class Resource
{
	public function __construct($info = null)
	{
		$this->info = $info;
	}

	public function get($name)
	{
		if ($this->info[$name]) {
			return $this->info[$name];
		}

		return null;
	}
}