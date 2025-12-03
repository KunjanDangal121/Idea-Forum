<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Models\Status;
use App\Models\Vote;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    use WithPagination;

    public $statusFilter = 'All'; 
    public $search = '';
    
    // NEW: Property for the input box
    public $newTopic = ''; 

    protected $queryString = [
        'statusFilter',
        'search',
    ];

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // NEW: Function to add a topic
    public function addTopic()
    {
        if (auth()->check() && auth()->user()->email === 'kunjandangal@gmail.com') {
            
            $this->validate(['newTopic' => 'required|min:2|max:20|unique:statuses,name']);

            Status::create(['name' => $this->newTopic]);

            $this->newTopic = ''; // Clear input
            session()->flash('success', 'Topic added!');
        }
    }

    public function vote($ideaId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $vote = Vote::where('user_id', auth()->id())
                    ->where('idea_id', $ideaId)
                    ->first();

        if ($vote) {
            $vote->delete();
        } else {
            Vote::create([
                'idea_id' => $ideaId,
                'user_id' => auth()->id(),
            ]);
        }
    }

    public function render()
    {
        $statuses = Status::all();

        $ideas = Idea::with(['user', 'status'])
            ->when($this->statusFilter && $this->statusFilter !== 'All', function ($query) {
                return $query->whereHas('status', function ($q) {
                    $q->where('name', $this->statusFilter);
                });
            })
            ->when($this->search && strlen($this->search) >= 3, function ($query) {
                return $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->withCount('votes')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.ideas-index', [
            'ideas' => $ideas,
            'statuses' => $statuses,
        ]);
    }
}
