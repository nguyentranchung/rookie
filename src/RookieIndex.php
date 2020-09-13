<?php


namespace NguyenTranChung\Rookie;

use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;

class RookieIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $name;
    public $filter;

    protected $queryString = ['filter'];

    public function mount($name)
    {
        $this->filter = request()->query('filter', $this->filter);
        $this->name = $name;
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function clearSearch($searchKey)
    {
        Arr::set($this->filter, $searchKey, '');
    }

    public function render()
    {
        request()->query->set('filter', $this->filter);

        return view('rookie::rookie-index', ['rookie' => Rookie::findOrFail($this->name)]);
    }
}
