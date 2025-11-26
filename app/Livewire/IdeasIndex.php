<?php

namespace App\Livewire;

use App\Models\Status;
use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
=======
use App\Models\Status;
>>>>>>> main

class IdeasIndex extends Component
{
    use WithPagination;

<<<<<<< HEAD
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
=======
    // Properties to bind to search and filter inputs
    public string $search = '';
    public string $statusFilter = 'All'; // Default filter state

    // Ensure pagination resets whenever a filter changes
    public function updated($property)
    {
        if ($property === 'search' || $property === 'statusFilter') {
            $this->resetPage();
        }
    }

    /**
     * Toggles a vote for a given idea.
     */
    public function vote(Idea $idea)
    {
        // 1. Authorization Check: Redirect guests to login page
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Toggle Logic
        // Checks if the user has already voted using the isVotedBy helper on the Idea model
        if ($idea->isVotedBy($user)) {
            // UNVOTE: User has voted, so detach (remove) the vote
            $idea->votes()->detach($user);
        } else {
            // VOTE: User has not voted, so attach (add) the vote
            $idea->votes()->attach($user);
        }
        
        // Livewire automatically refreshes the component to show the new count!
    }

  public function render()
    {
        $statuses = \App\Models\Status::all();

        // UPDATE THIS BLOCK
        $ideas = Idea::withCount(['votes', 'comments'])
            ->with(['user', 'status']) 
>>>>>>> main
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
