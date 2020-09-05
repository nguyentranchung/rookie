<?php

namespace NguyenTranChung\Rookie\Fields;

use NguyenTranChung\Rookie\Rookie;

abstract class Relation extends Field
{
    protected Rookie $rookie;
    protected string $relationType;
    protected bool $showCountOnly = false;


    public function __construct($attribute, $rookieClass)
    {
        parent::__construct($attribute);
        $this->rookie = new $rookieClass();
    }

    /**
     * @return mixed
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * @param  mixed  $relationType
     */
    public function setRelationType($relationType): void
    {
        $this->relationType = $relationType;
    }

    /**
     * @return bool
     */
    public function isShowCountOnly(): bool
    {
        return $this->showCountOnly;
    }

    /**
     * @return \NguyenTranChung\Rookie\Fields\Relation
     */
    public function showCountOnly()
    {
        $this->showCountOnly = true;
        return $this;
    }
}
