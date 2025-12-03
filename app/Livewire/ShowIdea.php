<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Idea;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithFileUploads; // <--- Import for file handling
use Illuminate\Support\Facades\Storage; // <--- Import for deleting files

class ShowIdea extends Component
{
    use WithFileUploads;

    public Idea $idea; 
    public string $newComment = ''; 
    public $statuses; 

    // Edit Properties
    public bool $isEditing = false; 
    public string $editedTitle = '';
    public string $editedDescription = '';
    public $newImage; // For uploading a new image during edit

    protected array $rules = [
        'newComment' => 'required|min:4|max:255',
        'editedTitle' => 'required|min:4|max:100',
        'editedDescription' => 'required|min:20',
        'newImage' => 'nullable|image|max:5120',
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->editedTitle = $idea->title;
        $this->editedDescription = $idea->description;
        $this->statuses = Status::all(); 
    }

    // === ADMIN STATUS ===
    public function updateStatus($newStatusId)
    {
        if (auth()->user()->email !== 'kunjandangal@gmail.com') { 
            session()->flash('error', 'You are not authorized.');
            return;
        }
        $this->idea->update(['status_id' => $newStatusId]);
        session()->flash('success', 'Status updated successfully!');
        $this->idea->refresh(); 
    }

    // === EDIT LOGIC ===
    public function startEdit()
    {
        $this->authorize('update', $this->idea); 
        $this->isEditing = true;
    }
    
    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->newImage = null; // Clear upload buffer
    }

    public function updateIdea()
    {
        $this->authorize('update', $this->idea); 
        
        $this->validate([
            'editedTitle' => 'required|min:4|max:100',
            'editedDescription' => 'required|min:20',
            'newImage' => 'nullable|image|max:5120',
        ]);

        // Handle Image Update
        if ($this->newImage) {
            // Delete old image if it exists
            if ($this->idea->image) {
                Storage::disk('public')->delete($this->idea->image);
            }
            // Store new image
            $imagePath = $this->newImage->store('ideas', 'public');
            $this->idea->image = $imagePath;
        }

        $this->idea->title = $this->editedTitle;
        $this->idea->description = $this->editedDescription;
        $this->idea->save(); // Save everything
        
        $this->isEditing = false; 
        $this->newImage = null;
        session()->flash('success', 'Idea updated successfully!');
        $this->idea->refresh();
    }

    public function removeImage()
    {
        $this->authorize('update', $this->idea);
        
        if ($this->idea->image) {
            Storage::disk('public')->delete($this->idea->image);
            $this->idea->update(['image' => null]);
            session()->flash('success', 'Image removed.');
        }
    }

    // === DELETE & COMMENT LOGIC ===
    public function deleteIdea()
    {
        $this->authorize('delete', $this->idea);
        
        // Delete image file if exists
        if ($this->idea->image) {
            Storage::disk('public')->delete($this->idea->image);
        }

        $this->idea->delete();
        session()->flash('success', 'Idea deleted successfully!');
        return redirect()->route('idea.index');
    }

    public function postComment()
    {
        if (!auth()->check()) { return redirect()->route('login'); }
        $this->validate(['newComment' => 'required|min:4']);
        $this->idea->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->newComment,
        ]);
        $this->newComment = '';
        session()->flash('success', 'Comment posted!');
    }

    public function deleteComment(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        session()->flash('success', 'Comment deleted!');
    }

    public function render()
    {
        return view('livewire.show-idea', [
            'comments' => $this->idea->comments()->with(['user', 'idea'])->latest()->get(),
        ]);
    }
}
