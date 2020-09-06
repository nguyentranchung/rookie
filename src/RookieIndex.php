<?php


namespace NguyenTranChung\Rookie;


use Livewire\Component;
use Livewire\WithPagination;

class RookieIndex extends Component
{
    use WithPagination;

    public string $name;
    public $search;

    protected $updatesQueryString = ['search'];

    public function mount($name)
    {
        $this->name = $name;
        $this->search = request()->query('filter', $this->search);
    }

    public function updatingSearch()
    {
        $this->page = 1;
    }

    public function getRookieProperty()
    {
        request()->query->set('filter', $this->search);

        $rookies = collect(config('rookie.rookies'));
        $rookie = $rookies->filter(fn($value, $key) => $key === $this->name)->firstOrFail();

        return new $rookie;
    }

    public function render()
    {
        return view('rookie::rookie-index');
    }
}
