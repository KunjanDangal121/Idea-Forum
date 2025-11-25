<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class ShowIdea extends Component
{
    // Property set via Route Model Binding (from the URL /ideas/{idea:id})
    public Idea $idea; 

    // Property bound to the comment form's textarea
    public string $newComment = ''; 
    
    // Validation rules for the new comment body
    protected array $rules = [
        'newComment' => 'required|min:4|max:255',
    ];

    public function mount(Idea $idea)
    {
        // Set the property based on the route binding
        $this->idea = $idea;
    }

    /**
     * Handles the comment form submission.
     */
    public function postComment()
    {
        // 1. Security Check: Stop if the user is not logged in
        if (!auth()->check()) {
            session()->flash('error', 'You must be logged in to post a comment.');
            return redirect()->back();
        }

        // 2. Validate the form data
        $this->validate();

        // 3. Create the Comment and associate it with the current Idea
        $this->idea->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->newComment,
        ]);
        
        // 4. Clear the form field for a clean user experience
        $this->newComment = '';

        // 5. Success feedback
        session()->flash('success', 'Comment posted successfully!');

        // 6. Redirect back to the same page to ensure the Livewire state is fully refreshed 
        //    and the new comment appears without a full page reload.
        return redirect(request()->header('Referer')); 
    }
    
    public function render()
    {
        return view('livewire.show-idea', [
            // Eager load comments and the users who posted them
            'comments' => $this->idea->comments()->with('user')->get(),
        ]);
    }
}
