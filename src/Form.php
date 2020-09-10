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
    public string $position = 'left';
    public ?string $helpText = null;
    public bool $save = true;

    public $value;
    public $default;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->label = Str::title($name);
        $this->placeholder = Str::title($name);
        $this->id = $name;
    }

    public function notSave()
    {
        $this->save = false;

        return $this;
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
        $this->language = $language;

        return $this;
    }

    public function positionRight()
    {
        $this->position = 'right';

        return $this;
    }

    public function helpText(?string $help)
    {
        $this->helpText = $help;

        return $this;
    }

    public function isPositionLeft()
    {
        return $this->position === 'left';
    }

    public function isPositionRight()
    {
        return !$this->isPositionLeft();
    }
}
