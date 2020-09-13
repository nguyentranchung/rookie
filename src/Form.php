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
    public bool $showOnCreation = true;
    public bool $showOnUpdate = true;
    public $translatable = false;

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

    /**
     * @param  array  $arguments
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    public function onlyOnCreation()
    {
        $this->showOnCreation = true;
        $this->showOnUpdate = false;

        return $this;
    }

    public function onlyOnUpdate()
    {
        $this->showOnCreation = false;
        $this->showOnUpdate = true;

        return $this;
    }

    public function notSave()
    {
        $this->save = false;

        return $this;
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

    public function isPositionRight()
    {
        return !$this->isPositionLeft();
    }

    public function isPositionLeft()
    {
        return $this->position === 'left';
    }

    public function isTranslatable()
    {
        return $this->translatable;
    }

    public function translatable()
    {
        $this->translatable = true;
        $this->language = request()->query('model-language', App::getLocale());

        return $this;
    }
}
