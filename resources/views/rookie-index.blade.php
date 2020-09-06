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
                <a href="#" class="btn btn-sm btn-outline-info">Add New </a>
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

        <table class="table table-hover">
            <thead>
            <tr>
                @foreach($rookie->fields() as $field)
                    <th>{!! $field->getHeader() !!}</th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            @if($rookie->searchableFields()->isNotEmpty())
                <tr style="color: inherit; background: inherit;">
                    @foreach($rookie->fields() as $field)
                        <td>
                            @if($field->isFilterable())
                                <div class="btn-group w-100">
                                    <input id="{{ 'search-'.$field->getAttribute() }}" class="form-control"
                                           wire:model.debounce.500ms="search.{{ $field->getAttribute() }}" type="text">
                                    @if(isset($this->search) && Arr::has($this->search, $field->getAttribute()) && filled($this->search[$field->getAttribute()]))
                                        <div wire:model="search.{{ $field->getAttribute() }}">
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
