<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth; // <-- NEW: Required for Auth::check()

class IdeasIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'All'; 

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
        $ideas = Idea::withCount('votes')
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->simplePaginate(10);

        return view('livewire.ideas-index', [
            'ideas' => $ideas,
        ]);
    }
}
