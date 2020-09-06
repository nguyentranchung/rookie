<?php


namespace NguyenTranChung\Rookie;


use Livewire\Component;
use Livewire\WithPagination;

class RookieIndex extends Component
{
    use WithPagination;

    public string $name;
    public $filter;

    protected $updatesQueryString = ['filter'];

    public function mount($name)
    {
        $this->name = $name;
        $this->filter = request()->query('filter', null);
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
        $rookie = $rookies->filter(fn($value, $key) => $key === $this->name)->firstOrFail();

        return new $rookie;
    }

    public function render()
    {
        return view('rookie::rookie-index');
    }
}
