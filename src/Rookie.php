<?php


namespace NguyenTranChung\Rookie;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use NguyenTranChung\Rookie\Fields\Field;
use NguyenTranChung\Rookie\Fields\Relation;
use Spatie\QueryBuilder\QueryBuilder;

abstract class Rookie
{
    protected string $modelClass;
    protected string $title;
    protected $models;
    protected $defaultSort = '-id';
    protected int $paginate = 10;

    public function query(): Builder
    {
        return $this->modelClass::query();
    }

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

    public function searchableFields()
    {
        return \collect($this->fields())->filter(fn(Field $field) => !$field instanceof Relation && $field->isSearchable());
    }

    abstract public function forms();

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

        $search = $this->searchableFields()->map(fn(Field $field) => $field->getSearch())->all();

        $sort = $this->normalFields()
            ->filter(fn(Field $field) => $field->isSortable())
            ->keyBy(fn(Field $field) => $field->getAttribute())
            ->keys()
            ->all();

        $query = QueryBuilder::for($this->query())
            ->when($with->isNotEmpty(), fn(Builder $q) => $q->with($with->all()))
            ->when($count->isNotEmpty(), fn(Builder $q) => $q->withCount($count->all()))
            ->allowedFilters($search)
            ->allowedSorts($sort)
            ->defaultSort($this->defaultSort);

        if ($this->paginate === 0) {
            $models = $query->get();
            $this->models = $models->toFlatTree()->paginate($models->count());
        } else {
            $this->models = $query->paginate($this->paginate);
        }

        return $this->models;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    abstract public function store(Request $request, $rookieName);

    // abstract public function update(Request $request);

    // abstract public function delete(Request $request);

}
