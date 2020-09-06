<?php

/**
 * @var \NguyenTranChung\Rookie\Fields\Field $field
 * @var \NguyenTranChung\Rookie\Rookie $rookie
 * @var \Illuminate\Database\Eloquent\Model $model
 */
$rookie = $this->rookie;
?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h3 class="card-title">
                    <a href="#" class="btn btn-sm btn-outline-info">Add New</a>
                </h3>
            </div>

            <div class="col-6 text-right">
                <div class="d-inline-flex dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> Filters
                    </button>
                    <div class="dropdown-menu dropdown-menu-right keep-open p-3" aria-labelledby="dropdownMenuButton">
                        <div class="text-left mb-4">
                            <label class="block">
                                Active
                            </label>
                            <div class="inline-block relative w-full">
                                <select class="form-control" wire:model="filters1" name="filters[]">
                                    <option value="">
                                        --
                                    </option>
                                </select>


                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <i data-feather="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive d-flex justify-content-center">
            {{ $rookie->models()->withQueryString()->onEachSide(5)->links() }}
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                @foreach($rookie->fields() as $field)
                    <th>{!! $field->getHeader() !!}</th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @if($rookie->filterableFields()->isNotEmpty())
                <tr style="color: inherit; background: inherit;">
                    @foreach($rookie->fields() as $field)
                        <td>
                            @if($field->isFilterable())
                                <div class="btn-group w-100">
                                    <input id="{{ 'filter-'.$field->getAttribute() }}" wire:keydown.enter="filter" class="form-control"
                                           wire:model="filter.{{ $field->getAttribute() }}" type="text">
                                    @if(isset($this->filter) && Arr::has($this->filter, $field->getAttribute()) && filled($this->filter[$field->getAttribute()]))
                                        <div wire:model="filter.{{ $field->getAttribute() }}">
                                            <span id="input-clear" class="far fa-times-circle" x-data @click="$dispatch('input', null)"></span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endif
            @foreach($rookie->models() as $model)
                <tr>
                    @foreach($rookie->fields() as $field)
                        <td>{!! $field->getValue($model) !!}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="table-responsive d-flex justify-content-center">
            {{ $rookie->models()->withQueryString()->onEachSide(5)->links() }}
        </div>
    </div>
</div>
