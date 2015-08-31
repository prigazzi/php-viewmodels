<?php
namespace Solution\View;

class View
{
    private $variables = [];
    
    private $attachedViews = [];

    private $template = '';

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function __get($name)
    {
        return $this->variables[$name] ? $this->variables[$name] : ""; //Replace by special placeholder
    }

    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function attachView($name, $view)
    {
        if ($view instanceof \Traversable) {
            $view = new ViewCollection($view);
        }

        $this->attachedViews[$name] = $view;
    }

    public function parse() //Need to implement a Template Engine
    {
        $attachedViews = $this->attachedViews;

        $this->variables["attachedView"] = function ($name) use ($attachedViews) {
            if ($attachedViews[$name] instanceof View) {
                return $attachedViews[$name]->parse();
            }

            return "";
        };

        ob_start();

        extract($this->variables);
        include $this->template;

        $output = ob_get_clean();

        return $output;
    }
}
