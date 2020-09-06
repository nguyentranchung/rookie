<?php


namespace NguyenTranChung\Rookie;


use Illuminate\Database\Eloquent\Builder;
use NguyenTranChung\Rookie\Fields\Field;
use NguyenTranChung\Rookie\Fields\Relation;
use Spatie\QueryBuilder\QueryBuilder;

class Rookie
{
    protected string $modelClass;
    protected string $title;
    protected $models;
    protected $defaultSort = '-id';

    /**
     * @return array
     */
    public function fields()
    {
        return [];
    }

    public function relationFields()
    {
        return \collect($this->fields())->filter(fn(Field $field) => $field instanceof Relation);
    }

    public function normalFields()
    {
        return \collect($this->fields())->filter(fn(Field $field) => !$field instanceof Relation);
    }

    public function filterableFields()
    {
        return \collect($this->fields())->filter(fn(Field $field) => !$field instanceof Relation && $field->isSortable());
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator | \Illuminate\Pagination\LengthAwarePaginator
     */
    public function models()
    {
        if (isset($this->models)) {
            return $this->models;
        }

        $with = $this->relationFields()
            ->filter(fn(Relation $field) => !$field->isShowCountOnly())
            ->keyBy(fn(Relation $field) => $field->getAttribute())
            ->keys();

        $count = $this->relationFields()
            ->filter(fn(Relation $field) => $field->isShowCountOnly())
            ->keyBy(fn(Relation $field) => $field->getAttribute())
            ->keys();

        $filter = $this->filterableFields()
            ->map(fn(Field $field) => $field->getFilter())
            ->all();

        $sort = $this->normalFields()
            ->filter(fn(Field $field) => $field->isSortable())
            ->keyBy(fn(Field $field) => $field->getAttribute())
            ->keys()
            ->all();

        $this->models = QueryBuilder::for($this->modelClass)
            ->when($with->isNotEmpty(), fn(Builder $q) => $q->with($with->all()))
            ->when($count->isNotEmpty(), fn(Builder $q) => $q->withCount($count->all()))
            ->allowedFilters($filter)
            ->allowedSorts($sort)
            ->defaultSort($this->defaultSort)
            ->paginate(10);

        return $this->models;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
