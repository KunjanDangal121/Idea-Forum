<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class IdeasIndex extends Component
{
    use WithPagination;

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
        $ideas = Idea::withCount('votes')
            ->with('user')
            // Apply Search Filter (searches within the title)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            // Apply Status Filter (framework for future use)
            ->when($this->statusFilter && $this->statusFilter !== 'All', function ($query) {
                // When you add a 'status' column, uncomment and modify this line:
                // $query->where('status', $this->statusFilter); 
            })
            ->latest()
            ->simplePaginate(10);

        return view('livewire.ideas-index', [
            'ideas' => $ideas,
        ]);
    }
}
