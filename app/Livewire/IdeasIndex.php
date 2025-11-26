<?php

namespace App\Livewire;

use App\Models\Status;
use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class IdeasIndex extends Component
{
    use WithPagination;

    // 1. Properties to bind to search and filter inputs
    public string $search = '';
    public string $statusFilter = 'All'; 

    // 2. Reset pagination when filters change
    public function updated($property)
    {
        if ($property === 'search' || $property === 'statusFilter') {
            $this->resetPage();
        }
    }

    /**
     * 3. Toggles a vote for a given idea.
     */
    public function vote(Idea $idea)
    {
        // Authorization Check
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Toggle Logic
        if ($idea->isVotedBy($user)) {
            $idea->votes()->detach($user);
        } else {
            $idea->votes()->attach($user);
        }
    }

    public function render()
    {
        // 4. Fetch all statuses for the dropdown
        $statuses = Status::all(); 

        $ideas = Idea::withCount(['votes', 'comments'])
            ->with(['user', 'status'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter && $this->statusFilter !== 'All', function ($query) {
                $query->whereHas('status', function ($statusQuery) {
                     $statusQuery->where('name', $this->statusFilter);
                });
            })
            ->latest()
            ->simplePaginate(10);

        // 5. Pass both $ideas and $statuses to the view
        return view('livewire.ideas-index', [
            'ideas' => $ideas,
            'statuses' => $statuses,
        ]);
    }
}
