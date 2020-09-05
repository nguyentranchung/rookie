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

    /**
     * @return array
     */
    public function fields()
    {
        return [];
    }

    public function models()
    {
        if (isset($this->models)) {
            return $this->models;
        }

        $with = \collect($this->fields())
            ->filter(fn(Field $field) => $field instanceof Relation && !$field->isShowCountOnly())
            ->keyBy(fn(Relation $field) => $field->getAttribute())
            ->keys();

        $count = \collect($this->fields())
            ->filter(fn(Field $field) => $field instanceof Relation && $field->isShowCountOnly())
            ->keyBy(fn(Relation $field) => $field->getAttribute())
            ->keys();

        $filter = \collect($this->fields())
            ->filter(fn(Field $field) => $field->isFilterable())
            ->map(fn(Field $field) => $field->getFilter())
            ->all();

        $sort = \collect($this->fields())
            ->filter(fn(Field $field) => !$field instanceof Relation && $field->isSortable())
            ->keyBy(fn(Field $field) => $field->getAttribute())
            ->keys()
            ->all();

        $this->models = QueryBuilder::for($this->modelClass)
            ->when($with->isNotEmpty(), fn(Builder $q) => $q->with($with->all()))
            ->when($count->isNotEmpty(), fn(Builder $q) => $q->withCount($count->all()))
            ->allowedFilters($filter)
            ->allowedSorts($sort)
            ->paginate();

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
