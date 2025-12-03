<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditProfile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $photo; // Temporary upload
    public $currentPhoto; // Existing photo path

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->currentPhoto = auth()->user()->profile_photo_path;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'photo' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $user = auth()->user();

        if ($this->photo) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Store new one
            $user->profile_photo_path = $this->photo->store('profile-photos', 'public');
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Profile updated successfully!');
        
        // Refresh page to show new avatar in header
        return redirect()->route('profile.edit'); 
    }

    public function render()
    {
        return view('livewire.edit-profile');
    }
}
