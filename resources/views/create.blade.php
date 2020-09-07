<?php
/**
 * @var \NguyenTranChung\Rookie\Fields\Field $field
 * @var \NguyenTranChung\Rookie\Rookie $rookie
 * @var \NguyenTranChung\Rookie\Form $form
 * @var \Illuminate\Database\Eloquent\Model $model
 */

?>
@extends(config('rookie.view.layout'))

@section(config('rookie.view.section'))
    <x-form action="{{ route('rookie.store', $rookieName) }}">
        @foreach($rookie->forms() as $form)
            @include('rookie::form')
        @endforeach
        <x-form-submit></x-form-submit>
    </x-form>
@endsection
