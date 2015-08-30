<?
namespace Solution\View;

class Factory
{
	protected $factories = [];
	protected $singletons = [];
	protected $params = [];

	public function factory($name, callable $factory)
	{
		$this->factories[$name] = $factory->bindTo($this);
	}

	public function singleton($name, callable $factory)
	{
		$this->factory($name, $factory);
		$this->singletons[$name] = true;
	}

	public function param($name)
	{
		if (count($params = func_get_args()) > 1) {
			// we want to set a Param
			array_shift($params);
			$this->params[$name] = array_shift($params);
		}  

		return $this->params[$name] ?: null;
	}

	public function get($name)
	{
		if (!$this->factories[$name]) {
			throw new Exception("I can't satisfy that dependency.");
		}

		if (is_object($this->singletons[$name])) {
			return $this->singletons[$name];
		}

		$args = func_get_args();
		array_shift($args);
		$instance = call_user_func_array($this->factories[$name], $args);

		if ($this->singletons[$name] === true) {
			$this->singletons[$name] = $instance;
		}

		return $instance;
	}
}