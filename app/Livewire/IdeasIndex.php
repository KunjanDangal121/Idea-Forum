<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    use WithPagination;

    // NEW: Properties to bind to search and filter inputs
    public string $search = '';
    public string $statusFilter = 'All'; // Default filter state

    // Ensure pagination resets whenever a filter changes
    public function updated($property)
    {
        if ($property === 'search' || $property === 'statusFilter') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $ideas = Idea::withCount('votes')
            ->with('user')
            // NEW: Apply Search Filter (searches within the title)
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            // NEW: Apply Status Filter (framework for future use)
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
