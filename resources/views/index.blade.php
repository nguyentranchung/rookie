@extends(config('rookie.view.layout', 'rookie::layout'))

@section(config('rookie.view.section', 'content'))
@livewire('rookie-index', ['name' => $rookieName])
@endsection
