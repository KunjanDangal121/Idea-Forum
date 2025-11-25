<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class ShowIdea extends Component
{
    // === Core Idea Properties ===
    public Idea $idea; 

    // === Comment Form Properties ===
    public string $newComment = ''; 

    // === Edit Form Properties ===
    public bool $isEditing = false; // Controls whether the form is visible
    public string $editedTitle = '';
    public string $editedDescription = '';

    // === Validation Rules ===
    protected array $rules = [
        // Rules for the Comment Form
        'newComment' => 'required|min:4|max:255',
        
        // Rules for the Edit Form (Idea Update)
        'editedTitle' => 'required|min:10|max:100',
        'editedDescription' => 'required|min:20',
    ];

    public function mount(Idea $idea)
    {
        // Set the core property based on the route binding
        $this->idea = $idea;
        
        // Initialize the edit form properties with the current idea data
        $this->editedTitle = $idea->title;
        $this->editedDescription = $idea->description;
    }

    // ====================================================================
    // Edit Functionality Methods
    // ====================================================================

    /**
     * Toggles the $isEditing property to show the form.
     */
    public function startEdit()
    {
        // Use policy check for backend safety
        $this->authorize('update', $this->idea); 
        
        $this->isEditing = true;
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
    }
    
    /**
     * Toggles the $isEditing property to hide the form without saving.
     */
    public function cancelEdit()
    {
        $this->isEditing = false;
        
        // Reset the form fields back to the original idea data
        $this->editedTitle = $this->idea->title;
        $this->editedDescription = $this->idea->description;
    }

    /**
     * Handles the form submission for updating the idea.
     */
    public function updateIdea()
    {
        // 1. Authorization & Validation
        $this->authorize('update', $this->idea); 
        $this->validate([
            'editedTitle' => 'required|min:10|max:100',
            'editedDescription' => 'required|min:20',
        ]);

        // 2. Action: Update the Idea in the database
        $this->idea->update([
            'title' => $this->editedTitle,
            'description' => $this->editedDescription,
        ]);
        
        // 3. Cleanup and Feedback
        $this->isEditing = false; // Hide the form
        session()->flash('success', 'Idea updated successfully!');
        
        // Force Livewire to refresh the data on the page
        $this->idea->refresh();
    }


    // ====================================================================
    // Comment Functionality Methods (Unchanged)
    // ====================================================================

    public function postComment()
    {
        if (!auth()->check()) {
            session()->flash('error', 'You must be logged in to post a comment.');
            return redirect()->back();
        }

        $this->validate(['newComment' => 'required|min:4|max:255']);

        $this->idea->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->newComment,
        ]);
        
        $this->newComment = '';
        session()->flash('success', 'Comment posted successfully!');
        return redirect(request()->header('Referer')); 
    }

    public function deleteIdea()
    {
        $this->authorize('delete', $this->idea);

        $this->idea->delete();

        session()->flash('success', 'Idea deleted successfully!');

        return redirect()->route('idea.index');
    }

    // ====================================================================
    // Rendering
    // ====================================================================
    
    public function render()
    {
        return view('livewire.show-idea', [
            'comments' => $this->idea->comments()->with('user')->get(),
        ]);
    }
}
