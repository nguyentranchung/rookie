<?php

/**
 * @var \NguyenTranChung\Rookie\Fields\Field $field
 * @var \NguyenTranChung\Rookie\Rookie $rookie
 * @var \NguyenTranChung\Rookie\Form $form
 * @var \Illuminate\Database\Eloquent\Model $model
 */
$method = is_null($model) ? "POST" : "PUT";
$forms = $rookie->forms();
?>
@extends(config('rookie.view.layout'))

@section(config('rookie.view.section'))
    <x-form :method="$method"
            action="{{ is_null($model) ? route('rookie.store', $rookieName) : route('rookie.update', [$rookieName, $rookieId]) }}">
        @bind($model)
        <div class="row">
            <div class="col col-lg-8">
                @foreach($forms as $form)
                    @if($form->isPositionLeft())
                        @include('rookie::form')
                    @endif
                @endforeach
            </div>
            <div class="col col-lg-4">
                @foreach($forms as $form)
                    @if($form->isPositionRight())
                        @include('rookie::form')
                    @endif
                @endforeach
            </div>
        </div>
        @endbind
        <x-form-submit></x-form-submit>
    </x-form>
@endsection
