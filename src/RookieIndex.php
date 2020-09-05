<?php


namespace NguyenTranChung\Rookie;


use Livewire\Component;

class RookieIndex extends Component
{
    public string $name;
    public $filter;

    public function mount($name)
    {
        $this->name = $name;
    }

    public function filter()
    {
        request()->query->add([
            'filter' => $this->filter,
        ]);
    }

    public function getRookieProperty()
    {
        $rookies = collect(config('rookie.rookies'));
        $rookie = $rookies->firstOrFail(fn($value) => $value === $this->name);

        return new $rookie;
    }

    public function render()
    {
        return view('rookie::rookie-index');
    }
}
