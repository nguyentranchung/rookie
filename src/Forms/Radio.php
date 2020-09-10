<?php

namespace NguyenTranChung\Rookie\Forms;

use NguyenTranChung\Rookie\Form;

class Radio extends Form
{
    public string $type = 'radio';
    public array $items = [];

    public function items(array $items)
    {
        $this->items = $items;

        return $this;
    }
}
