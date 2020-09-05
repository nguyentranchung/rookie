<?php

/**
 * @var \NguyenTranChung\Rookie\Fields\Field $field
 * @var \NguyenTranChung\Rookie\Rookie $rookie
 * @var \Illuminate\Database\Eloquent\Model $model
 */
$rookie = $this->rookie;
?>
<div class="card mt-5">
    <div class="card-body">
        <div>

            <div class="form-group">
                <label class="sr-only" for="filter">Search</label>
                <input wire:keydown.enter="filter" class="form-control" wire:model="filter.name" type="text">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" wire:click="filter">Search</button>
            </div>
        </div>

        <div>
            {{ $rookie->models()->links() }}
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                @foreach($rookie->fields() as $field)
                    <th>{!! $field->getHeader() !!}</th>
                @endforeach
            </tr>
            </thead>
            @foreach($rookie->models() as $model)
                @if($loop->first)
                    <tr>
                        @foreach($rookie->fields() as $field)
                            @if($field->isFilterable())
                                <td>
                                    <input wire:keydown.enter="filter" class="form-control" wire:model="filter.{{ $field->getAttribute() }}" type="text">
                                </td>
                            @else
                                <td></td>
                            @endif
                        @endforeach
                    </tr>
                @endif
                <tr>
                    @foreach($rookie->fields() as $field)
                        <td>{!! $field->getValue($model) !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
</div>
