<?php
use Solution\View\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->factory = new Factory();
	}

	public function testSetAndGetParams()
	{
		$factory = $this->factory;
		$this->assertNull($factory->param("UndefinedParam"));

		$factory->param('name', "param1");
		$this->assertEquals('param1', $factory->param('name'));

		$factory->param('name', "anotherParam");
		$this->assertEquals('anotherParam', $factory->param('name'));

		$factory->param('name', null);
		$this->assertNull($factory->param('name'));
	}

	public function testBasicFactories()
	{
		$factory = $this->factory;
		$factory->factory("SimpleClass", function() {
			$class = new stdClass();
			$class->one = 1;

			return $class;
		});

		$simpleClass = $factory->get('SimpleClass');
		$this->assertInstanceOf('stdClass', $simpleClass);
		$this->assertEquals(1, $simpleClass->one);
		$this->assertEquals($simpleClass, $factory->get('SimpleClass'));
	}

	public function testFactoriesWithAccessToFactory()
	{
		$factory = $this->factory;
		$factory->factory("SimpleClass", function() {
			$class = new stdClass();
			$class->one = 1;

			return $class;
		});

		$factory->factory("AnotherClass", function() {
			$simpleClass = $this->get('SimpleClass');
			$simpleClass->two = 2;

			return $simpleClass;
		});

		$anotherClass = $factory->get("AnotherClass");
		$this->assertInstanceOf('stdClass', $anotherClass);
		$this->assertEquals(1, $anotherClass->one);
		$this->assertEquals(2, $anotherClass->two);
		$this->assertEquals($anotherClass, $factory->get("AnotherClass"));
	}

	public function testSingleton()
	{
		$factory = $this->factory;
		$factory->singleton("singletonClass", function() {
			$newClass = new stdClass();
			$newClass->one = "1";

			return $newClass;
		});

		$singleton = $factory->get('singletonClass');
		$this->assertInstanceOf('stdClass', $singleton);
		$this->assertEquals("1", $singleton->one);
		$this->assertSame($singleton, $factory->get('singletonClass'));

		$factory->get('singletonClass')->one = "2";

		$this->assertEquals("2", $singleton->one);
	}

	public function testFactoriesWithSingleParam()
	{
		$factory = $this->factory;
		$factory->factory("simpleClass", function($param) {
			$simpleClass = new StdClass();
			$simpleClass->param = $param;

			return $simpleClass;
		});

		$simpleClass = $factory->get("simpleClass", "factoryParam");
		$this->assertEquals("factoryParam", $simpleClass->param);
	}

	public function testSingletonWithMultipleParams()
	{
		$factory = $this->factory;
		$factory->singleton('singletonClass', function($one, $two, $three) {
			$singletonClass = new stdClass();
			$singletonClass->params = [$one, $two, $three];

			return $singletonClass;
		});

		$params = ['1', '2', '3'];
		$singletonClass = $factory->get('singletonClass', $params[0], $params[1], $params[2]);
		$this->assertSame($singletonClass, $factory->get('singletonClass', $params[0], $params[1], $params[2]));
		$this->assertEquals($singletonClass->params, $params);
	}
}