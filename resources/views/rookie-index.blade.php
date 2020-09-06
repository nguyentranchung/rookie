<?php

/**
 * @var \NguyenTranChung\Rookie\Fields\Field $field
 * @var \NguyenTranChung\Rookie\Rookie $rookie
 * @var \Illuminate\Database\Eloquent\Model $model
 */
$rookie = $this->rookie;
?>
<div class="card">
    <div class="card-body">
        <div>
            @if($rookie->filterableFields()->isNotEmpty())
                <div class="form-group">
                    <label class="sr-only" for="filter">Search</label>
                    <input wire:keydown.enter="filter" class="form-control" wire:model="filter.name" type="text">
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary" wire:click="filter">Search</button>
            </div>
        </div>

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
                        @if($field->isFilterable())
                            <td>
                                <div class="btn-group w-100">
                                    <input id="{{ 'filter-'.$field->getAttribute() }}" wire:keydown.enter="filter" class="form-control"
                                           wire:model.debounce.500ms="filter.{{ $field->getAttribute() }}" type="text">
                                    @if(isset($this->filter) && Arr::has($this->filter, $field->getAttribute()))
                                        <span id="input-clear" class="far fa-times-circle"
                                              onclick="document.getElementById('{{ 'filter-'.$field->getAttribute() }}').value=''"></span>
                                    @endif
                                </div>
                            </td>
                        @else
                            <td></td>
                        @endif
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
