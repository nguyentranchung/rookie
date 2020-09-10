<?php


namespace NguyenTranChung\Rookie;


use Livewire\Component;
use Livewire\WithPagination;

class RookieIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public string $name;
    public $search;

    protected $queryString = ['search'];

    public function mount($name)
    {
        $this->search = request()->query('search', $this->search);
        $this->name = $name;
    }

    public function updatingSearch()
    {
        $this->page = 1;
    }

    public function render()
    {
        request()->query->set('filter', $this->search);

        return view('rookie::rookie-index', ['rookie' => Rookie::findOrFail($this->name)]);
    }
}
