<?php

namespace NguyenTranChung\Rookie\Forms;

use NguyenTranChung\Rookie\Form;

class Select extends Form
{
    public string $type = 'select';
    public $options;
    public bool $multiple = false;

    public function options(callable $options)
    {
        $this->options = $options;

        return $this;
    }

    public function multiple()
    {
        $this->multiple = true;

        return $this;
    }
}
