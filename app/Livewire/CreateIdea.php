<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class CreateIdea extends Component
{
    // Properties bound to the form fields
    public string $title = '';
    public string $description = '';

    // Validation rules
    protected array $rules = [
        'title' => 'required|min:10|max:100',
        'description' => 'required|min:20',
    ];

    public function submitIdea()
    {
        $this->validate();

        Idea::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Idea submitted successfully!');
        return redirect()->route('idea.index');
    }

    public function render()
    {
        return view('livewire.create-idea');
    }
}
