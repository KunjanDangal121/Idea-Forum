<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class CreateIdea extends Component
{
    // Properties bound to the form fields
    public string $title = '';
    public string $description = '';

    // Validation rules for the form submission
    protected array $rules = [
        'title' => 'required|min:10|max:100',
        'description' => 'required|min:20',
    ];

    /**
     * Handles the form submission and saves the new idea.
     */
    public function submitIdea()
    {
        // 1. Validate the input against the rules
        $this->validate();

        // 2. Create the Idea in the database
        // The user is authenticated due to the 'auth' middleware on the route.
        Idea::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
        ]);

        // 3. Send a success message and redirect to the index page
        session()->flash('success', 'Idea submitted successfully!');
        return redirect()->route('idea.index');
    }

    public function render()
    {
        // Livewire automatically uses the default layout (app.blade.php)
        return view('livewire.create-idea');
    }
}
