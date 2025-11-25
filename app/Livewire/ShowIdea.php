<?php

namespace App\Livewire;

use App\Models\Comment;
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
        'newComment' => 'required|min:4|max:255',
        'editedTitle' => 'required|min:10|max:100',
        'editedDescription' => 'required|min:20',
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        
        // Initialize the edit form properties with the current idea data
        $this->editedTitle = $idea->title;
        $this->editedDescription = $idea->description;
    }

    // ====================================================================
    // Edit Functionality Methods
    // ====================================================================

    public function startEdit()
    {
        $this->authorize('update', $this->idea); 
        $this->isEditing = true;
    }
    
    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->editedTitle = $this->idea->title;
        $this->editedDescription = $this->idea->description;
    }

    public function updateIdea()
    {
        $this->authorize('update', $this->idea); 
        $this->validate([
            'editedTitle' => 'required|min:10|max:100',
            'editedDescription' => 'required|min:20',
        ]);

        $this->idea->update([
            'title' => $this->editedTitle,
            'description' => $this->editedDescription,
        ]);
        
        $this->isEditing = false; // Hide the form
        session()->flash('success', 'Idea updated successfully!');
        $this->idea->refresh();
    }


    // ====================================================================
    // Delete and Comment Functionality
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

    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        session()->flash('success', 'Comment deleted successfully!');
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
