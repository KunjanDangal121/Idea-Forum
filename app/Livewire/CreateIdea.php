<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Livewire\WithFileUploads; // <--- REQUIRED FOR IMAGES

class CreateIdea extends Component
{
    use WithFileUploads; // <--- TRAIT IMPORT

    public string $title = '';
    public string $description = '';
    public $image; // <--- PROPERTY FOR IMAGE

    protected array $rules = [
        'title' => 'required|min:4|max:100',
        'description' => 'required|min:4',
        'image' => 'nullable|image|max:5120', // Max 5MB
    ];

    public function submitIdea()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('ideas', 'public');
        }

        Idea::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'status_id' => 1,
            'image' => $imagePath,
        ]);

        session()->flash('success', 'Idea submitted successfully!');
        return redirect()->route('idea.index');
    }

    public function render()
    {
        return view('livewire.create-idea');
    }
}
