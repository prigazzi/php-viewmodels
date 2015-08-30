<?php
namespace Solution\Api;

use \Solution\Api\Resource;

class ResourceGenerator
{
	protected static $adj = [
		"Awesome",
		"Incredible",
		"Fabulous",
		"Grandious",
		"Superb",
		"Kind-of-so-so"
	];

	public static function createProductResource()
	{
		foreach (static::$adj as $adjective) {
			$product = new Resource([
				"title" => "$adjective Product",
				"content" => new Resource([
					"description" => sprintf("This is a%s $adjective Product.", 
						(preg_match('/[aeiou]/i', $adjective[0])?'n':''))
				]),
				"price" => new Resource([
					"priceInVat" => mt_rand(0,1000) / 100
				])
			]);

			yield $product;
		}
	}
}