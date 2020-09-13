<?php

namespace NguyenTranChung\Rookie\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;

class Field
{
    protected string $attribute;
    protected string $header;
    protected $value;
    protected string $component = 'default';
    /**
     * @see https://spatie.be/docs/laravel-query-builder/v2/features/filtering
     */
    protected $search = null;
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
     * @return \NguyenTranChung\Rookie\Fields\Field|\NguyenTranChung\Rookie\Fields\Relation
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSearchable(): bool
    {
        return !!$this->search;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @return mixed
     */
    public function getSearchKey()
    {
        return $this->search instanceof AllowedFilter ? $this->search->getName() : $this->search;
    }

    /**
     * @param  AllowedFilter|string|null  $search
     *
     * @return \NguyenTranChung\Rookie\Fields\Field
     */
    public function search($search = null)
    {
        $this->search = $search ?: AllowedFilter::partial($this->attribute)->ignore(null);

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

        $value = $model->getAttribute($attribute);

        return $value ?: '—';
    }

    /**
     * @param  callable|string  $value
     *
     * @return \NguyenTranChung\Rookie\Fields\Field
     */
    public function setValue($value)
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
