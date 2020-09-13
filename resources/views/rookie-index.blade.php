<?php

/**
 * @var \NguyenTranChung\Rookie\Fields\Field $field
 * @var \NguyenTranChung\Rookie\Rookie $rookie
 * @var \Illuminate\Database\Eloquent\Model $model
 */

// $rookie = $this->rookie;
?>
<div class="card">
    @include('rookie::style')

    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <a href="{{ route('rookie.create', $this->name) }}" class="btn btn-sm btn-outline-info">Add New </a>
            </div>

            <div class="col-6 text-right">
                <div class="d-inline-flex dropdown">
                    <button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> Filters
                    </button>
                    <div class="dropdown-menu dropdown-menu-right keep-open p-3" aria-labelledby="dropdownMenuButton" style="min-width: 15rem">
                        <label class="d-block">Active</label>
                        <div class="d-block">
                            <select class="custom-select" wire:model="filters" name="filters[]">
                                <option value="">--- ---</option>
                            </select>
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

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width: 10px">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheckAll">
                            <label class="custom-control-label" for="customCheckAll"></label>
                        </div>
                    </th>
                    @foreach($rookie->fields() as $field)
                        <th>{!! $field->getHeader() !!}</th>
                    @endforeach
                </tr>
                </thead>

                <tbody>
                @if($rookie->searchableFields()->isNotEmpty())
                    <tr style="color: inherit; background: inherit;">
                        <td></td>
                        @foreach($rookie->fields() as $field)
                            <td>
                                @if($field->isSearchable())
                                    <div class="btn-group w-100">
                                        <input id="{{ 'search-'.$field->getAttribute() }}" class="form-control"
                                               wire:model.debounce.500ms="search.{{ $field->getSearchKey() }}" type="text">
                                        @if(isset($this->filter) && Arr::has($this->filter, $field->getSearchKey()) && filled($this->filter[$field->getSearchKey()]))
                                            <div wire:model="search.{{ $field->getSearchKey() }}">
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
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck{{ $model->getKey() }}">
                                <label class="custom-control-label" for="customCheck{{ $model->getKey() }}"></label>
                            </div>
                        </td>
                        @foreach($rookie->fields() as $field)
                            <td>
                                @if($rookie->getTitle() === $field->getAttribute())
                                    <a class="font-weight-bold" href="{{ route('rookie.edit', [$name, $model->getKey()]) }}">
                                        {!! $field->getValue($model) !!}
                                    </a>
                                    <div class="row-actions">
                                        <a href="#">View</a>&nbsp;|&nbsp;
                                        <a href="#">Edit</a>&nbsp;|&nbsp;
                                        <a href="#">Delete</a>&nbsp;|&nbsp;
                                    </div>
                                @else
                                    {!! $field->getValue($model) !!}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-responsive d-flex justify-content-center">
            {{ $rookie->models()->withQueryString()->onEachSide(5)->links() }}
        </div>
    </div>
</div>
