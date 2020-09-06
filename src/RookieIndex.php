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
        $this->filter = request()->query('filter', $this->filter);
    }

    public function updatingFilter()
    {
        $this->page = 1;
    }

    public function getRookieProperty()
    {
        request()->query->set('filter', $this->filter);

        $rookies = collect(config('rookie.rookies'));
        $rookie = $rookies->filter(fn($value, $key) => $key === $this->name)->firstOrFail();

        return new $rookie;
    }

    public function render()
    {
        return view('rookie::rookie-index');
    }
}
