<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $ideas = Idea::withCount('votes')
            ->with('user')
            ->latest()
            ->simplePaginate(10);

        return view('livewire.ideas-index', [
            'ideas' => $ideas,
        ]);
    }
}
