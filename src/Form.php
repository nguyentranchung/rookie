<?php

namespace NguyenTranChung\Rookie;

use Illuminate\Support\Str;

abstract class Form
{

    public string $name;
    public string $type;
    public string $label;
    public ?string $language = null;
    public string $placeholder = '';
    public string $id = '';
    public string $class = '';

    public $value;
    public $default;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param  string  $type
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->label = Str::title($name);
        $this->placeholder = Str::title($name);
        $this->id = $name;
    }

    /**
     * @param  array  $arguments
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    public function class($class)
    {
        $this->class = $class;

        return $this;
    }

    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }

    public function placeholder(string $string)
    {
        $this->placeholder = $string;

        return $this;
    }


    public function language($language)
    {
        $this->name .= "[{$language}]";

        return $this;
    }

    public function positionRight()
    {
        $this->attributes->offsetSet('position', 'right');

        return $this;
    }

    public function isPositionLeft()
    {
        return $this->attributes->get('position', 'left') === 'left';
    }

    public function isPositionRight()
    {
        return !$this->isPositionLeft();
    }
}
