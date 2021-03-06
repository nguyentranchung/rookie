<?php


namespace NguyenTranChung\Rookie;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use NguyenTranChung\Rookie\Fields\Field;
use NguyenTranChung\Rookie\Fields\Relation;
use Spatie\QueryBuilder\QueryBuilder;

use function collect;

abstract class Rookie
{
    protected static string $name;
    protected static string $modelClass;
    protected string $title;
    protected $models;
    protected $defaultSort = '-id';
    protected int $paginate = 10;

    public function __construct()
    {
        config()->set('form-components.framework', 'bootstrap-4');
    }

    /**
     * @param $rookieName
     *
     * @return static | null
     */
    public static function find($rookieName)
    {
        $rookies = collect(config('rookie.rookies'));
        $rookie = $rookies->filter(fn($rookie) => $rookie::getName() === $rookieName)->first();

        return $rookie ? new $rookie : null;
    }

    public static function findByModelClass($class)
    {
        $rookies = collect(config('rookie.rookies'));
        $rookie = $rookies->filter(fn($rookie) => $rookie::getModelClass() === $class)->first();

        return $rookie ? new $rookie : null;
    }

    /**
     * @param $rookieName
     *
     * @return static
     */
    public static function findOrFail($rookieName)
    {
        $rookie = static::find($rookieName);
        abort_unless((bool) $rookie, 404);

        return $rookie;
    }

    /**
     * @return string
     */
    public static function getModelClass(): string
    {
        return static::$modelClass;
    }

    public function query(): Builder
    {
        return static::$modelClass::query();
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
        return collect($this->fields())->filter(fn(Field $field) => $field instanceof Relation);
    }

    public function normalFields()
    {
        return collect($this->fields())->filter(fn(Field $field) => !$field instanceof Relation);
    }

    public function searchableFields()
    {
        return collect($this->fields())->filter(fn(Field $field) => !$field instanceof Relation && $field->isSearchable());
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

    public function store(Request $request)
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = new static::$modelClass;
        foreach ($this->forms() as $form) {
            /** @var \NguyenTranChung\Rookie\Form $form */
            if (!$form->save) {
                continue;
            }

            if (!$form->showOnCreation) {
                continue;
            }

            $model->setAttribute($form->name, $request->input($form->name));
        }

        $model->save();

        return redirect()->route('rookie.index', $this::$name);
    }

    public function update(Request $request, $rookieId)
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = static::$modelClass::findOrFail($rookieId);

        foreach ($this->forms() as $form) {
            /** @var \NguyenTranChung\Rookie\Form $form */
            if (!$form->save) {
                continue;
            }

            if (!$form->showOnUpdate) {
                continue;
            }

            if ($form->translatable) {
                $model->setTranslation($form->name, $form->language, $request->input($form->name)[$form->language]);
                continue;
            }

            $model->setAttribute($form->name, $request->input($form->name));
        }

        $model->save();

        return redirect()->route('rookie.index', $this::$name);
    }

    public function delete(Request $request, $rookieId)
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = static::$modelClass::findOrFail($rookieId);

        $model->delete();

        return redirect()->route('rookie.index', $this::$name);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return static::$name;
    }

}
