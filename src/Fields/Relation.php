<?php

namespace NguyenTranChung\Rookie\Fields;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use NguyenTranChung\Rookie\Rookie;

abstract class Relation extends Field
{
    protected Rookie $rookie;
    protected string $relationType;
    protected bool $showCountOnly = false;


    public function __construct($attribute, $rookieClass)
    {
        parent::__construct($attribute);

        if ($rookieClass) {
            $this->rookie = new $rookieClass();
        }
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
     * @return \NguyenTranChung\Rookie\Fields\Relation
     */
    public function showCountOnly()
    {
        $this->showCountOnly = true;
        return $this;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return mixed
     */
    public function getValue(Model $model)
    {
        $attribute = $this->attribute;
        if (is_null($model)) {
            return null;
        }

        if (isset($this->value)) {
            if (\is_callable($this->value)) {
                $value = $this->value;
                return $value($model) ?: '—';
            }

            if (\is_string($this->value)) {
                $attribute = $this->value;
            }
        }

        if ($this->isShowCountOnly()) {
            $attribute .= '_count';
        }

        $value = $model->getAttribute($attribute);
        if ($this instanceof Relation && !$this->isShowCountOnly()) {
            $value = $value instanceof Model ? collect(Arr::wrap($value)) : $value;
        }

        try {
            if ($value instanceof Collection) {
                if ($value->isEmpty()) {
                    return '—';
                }
                return $value->reduce(function ($html, Model $model) {
                    return $html.html()
                            ->a(
                                route('rookie.edit', [$this->getRookieName($model), $model->getKey()]),
                                $model->getAttribute($this->getRookieTitle($model))
                            )
                            ->class('badge badge-secondary mr-1');
                }, '');
            }
        } catch (Exception $exception) {
            dump($exception->getMessage());
        }

        return $value ?: '—';
    }

    /**
     * @return bool
     */
    public function isShowCountOnly(): bool
    {
        return $this->showCountOnly;
    }

    public function getRookieName(Model $model)
    {
        return $this->getRookie($model) ? $this->getRookie($model)::getName() : '';
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return \NguyenTranChung\Rookie\Rookie | null
     */
    public function getRookie(Model $model)
    {
        if ($this instanceof MorphTo) {
            return Rookie::findByModelClass(get_class($model));
        }

        return $this->rookie;
    }

    public function getRookieTitle(Model $model)
    {
        return $this->getRookie($model) ? $this->getRookie($model)->getTitle() : '';
    }
}
