<?php

namespace NguyenTranChung\Rookie\Fields;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Field
{
    protected string $attribute;
    protected string $header;
    protected $value;
    protected string $component = 'default';
    /**
     * @see https://spatie.be/docs/laravel-query-builder/v2/features/filtering
     */
    protected $filter = null;
    protected bool $sortable = false;

    public function __construct($attribute)
    {
        $this->attribute = $attribute;
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

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header ?? Str::title($this->attribute);
    }

    /**
     * @param  mixed  $header
     *
     * @return \NguyenTranChung\Rookie\Fields\Field | \NguyenTranChung\Rookie\Fields\Relation
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFilterable(): bool
    {
        return !!$this->filter;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param  null  $filter
     *
     * @return \NguyenTranChung\Rookie\Fields\Field
     */
    public function filter($filter = null)
    {
        $this->filter = $filter ?: $this->attribute;

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

        if ($this instanceof Relation && $this->isShowCountOnly()) {
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
                return $value->reduce(function ($html, Model $value) {
                    return $html.html()
                            ->a(
                                route('admin.resources.edit', [
                                    'resourceName' => 'xxx',
                                    'resourceId' => $value->getKey(),
                                ]),
                                $value->getAttribute($this->rookie->getTitle())
                            )
                            ->class('badge badge-secondary mr-1');
                }, '');
            }
        } catch (Exception $exception) {
            dd($value);
        }

        return $value ?: '—';
    }

    /**
     * @param  mixed  $value
     *
     * @return \NguyenTranChung\Rookie\Fields\Field
     */
    public function setValue(callable $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @return \NguyenTranChung\Rookie\Fields\Field
     */
    public function sortable()
    {
        $this->sortable = true;

        return $this;
    }
}
