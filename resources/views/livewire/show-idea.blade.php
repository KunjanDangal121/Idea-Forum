<div class="max-w-3xl mx-auto py-10 px-4"> 

    <div class="mb-8">
        <a href="{{ route('idea.index') }}" class="inline-flex items-center text-sm font-bold text-[#B80C09]/80 hover:text-[#B80C09] transition duration-200 group bg-white/50 px-4 py-2 rounded-full backdrop-blur-sm shadow-sm hover:shadow-md">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Back to Feed
        </a>
    </div>

    {{-- MAIN CARD --}}
    <div class="glass bg-white/80 rounded-3xl shadow-xl overflow-visible relative border border-white/50">
        
        @if ($isEditing)
            <div class="p-8">
                <form wire:submit.prevent="updateIdea" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-[#040F16] mb-2">Title</label>
                        <input wire:model.defer="editedTitle" type="text" class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#B80C09] focus:border-[#B80C09] bg-white/50 backdrop-blur-sm">
                        @error('editedTitle') <span class="text-xs text-[#B80C09] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#040F16] mb-2">Description</label>
                        <textarea wire:model.defer="editedDescription" rows="6" class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-[#B80C09] focus:border-[#B80C09] bg-white/50 backdrop-blur-sm"></textarea>
                        @error('editedDescription') <span class="text-xs text-[#B80C09] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    {{-- Image Controls --}}
                    <div class="p-5 bg-white/60 rounded-2xl border border-gray-200">
                        <label class="block text-sm font-bold text-[#040F16] mb-3">Update Image</label>
                        @if ($idea->image && !$newImage)
                            <div class="flex items-center gap-4 mb-4">
                                <img src="{{ Storage::url($idea->image) }}" class="w-24 h-24 object-cover rounded-xl border border-white shadow-sm">
                                <button type="button" wire:click="removeImage" class="text-xs text-[#B80C09] font-bold hover:underline">Remove Image</button>
                            </div>
                        @endif
                        <input wire:model.live="newImage" type="file" class="text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#B80C09]/10 file:text-[#B80C09] hover:file:bg-[#B80C09]/20 cursor-pointer"/>
                        @error('newImage') <span class="text-xs text-[#B80C09] font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button wire:click.prevent="cancelEdit" type="button" class="bg-gray-100 hover:bg-gray-200 text-[#040F16] font-bold px-6 py-2.5 rounded-xl transition">Cancel</button>
                        <button type="submit" class="bg-[#B80C09] hover:bg-[#8f0907] text-white font-bold px-6 py-2.5 rounded-xl shadow-lg shadow-[#B80C09]/30 transition">Save Changes</button>
                    </div>
                </form>
            </div>
        @else
            <div class="p-8">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-full border-4 border-white shadow-md">
                        <div>
                            <div class="font-bold text-[#040F16] text-lg">{{ $idea->user->name }}</div>
                            <div class="text-[#040F16]/50 text-xs font-semibold">{{ $idea->created_at->toDayDateTimeString() }}</div>
                        </div>
                    </div>

                    {{-- GLASS STATUS BUTTON --}}
                    <div x-data="{ isOpen: false }" class="relative">
                        <button 
                            @click="@if(auth()->check() && auth()->user()->email === 'kunjandangal@gmail.com') isOpen = !isOpen @else alert('Please contact the admin of this page.') @endif"
                            type="button"
                            class="glass-red flex items-center gap-2 bg-[#B80C09]/90 text-white font-bold text-xs uppercase px-5 py-2.5 rounded-full transition duration-200 hover:scale-105 shadow-lg shadow-[#B80C09]/30"
                        >
                            <span>{{ $idea->status->name }}</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 mt-2 w-56 z-50 rounded-2xl shadow-2xl glass-red p-2" style="display: none;">
                            @foreach ($statuses as $status)
                                <button wire:click="updateStatus({{ $status->id }}); isOpen = false" class="block w-full text-left px-4 py-2 text-sm font-bold text-white rounded-xl hover:bg-white/20 transition">{{ $status->name }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <h1 class="text-3xl md:text-4xl font-bold text-[#040F16] mb-6 leading-tight">{{ $idea->title }}</h1>
                @if ($idea->image)
                    <div class="mb-8 rounded-2xl overflow-hidden shadow-lg border border-white/50">
                        <img src="{{ Storage::url($idea->image) }}" alt="Idea Image" class="w-full object-cover">
                    </div>
                @endif
                <div class="text-[#040F16]/80 text-lg leading-8 mb-8 whitespace-pre-line font-medium">
                    {{ $idea->description }}
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-between pt-6 border-t border-[#040F16]/5">
                    <div class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold bg-[#B80C09]/10 text-[#B80C09] border border-[#B80C09]/20">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
                        <span>{{ $idea->votes_count }} Votes</span>
                    </div>

                    @can('update', $idea)
                        <div class="flex items-center gap-3">
                            <button wire:click="startEdit" class="px-4 py-2 text-sm font-bold text-[#040F16]/60 hover:text-[#040F16] bg-gray-100 hover:bg-gray-200 rounded-lg transition">Edit</button>
                            <button wire:click="deleteIdea" onclick="return confirm('Are you sure?')" class="px-4 py-2 text-sm font-bold text-[#B80C09] hover:bg-[#B80C09]/10 rounded-lg transition border border-[#B80C09]/20">Delete</button>
                        </div>
                    @endcan
                </div>
            </div>
        @endif
    </div>

    {{-- COMMENTS --}}
    <div id="comments" class="mt-12 max-w-2xl mx-auto">
        <h2 class="text-xl font-bold mb-6 text-[#040F16] flex items-center gap-2">
            <span>Discussion</span>
            <span class="bg-[#B80C09]/10 text-[#B80C09] text-xs px-2.5 py-1 rounded-full">{{ $comments->count() }}</span>
        </h2>

        @auth
            <div class="glass bg-white/70 p-6 mb-8 rounded-2xl shadow-sm">
                <form wire:submit.prevent="postComment">
                    <textarea wire:model.live="newComment" rows="3" placeholder="Add a comment..." class="w-full bg-white/50 border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-[#B80C09] focus:border-[#B80C09] text-[#040F16] placeholder-gray-400 backdrop-blur-sm"></textarea>
                    @error('newComment') <span class="text-xs text-[#B80C09] mt-2 block font-bold">{{ $message }}</span> @enderror
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-[#040F16] hover:bg-[#B80C09] text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-lg transform hover:-translate-y-0.5">Post Comment</button>
                    </div>
                </form>
            </div>
        @else
            <div class="glass bg-white/50 p-8 rounded-2xl text-center border-dashed border-2 border-[#B80C09]/20 mb-8">
                <p class="text-[#040F16] font-bold">Please <a href="/login" class="text-[#B80C09] hover:underline">log in</a> to join the discussion.</p>
            </div>
        @endauth

        <div class="space-y-6">
            @forelse ($comments as $comment)
                <div class="flex gap-4 group">
                    <img src="{{ $comment->user->getAvatar() }}" class="w-10 h-10 rounded-full border border-white shadow-sm flex-shrink-0">
                    <div class="flex-1 glass bg-white/60 p-5 rounded-2xl rounded-tl-none shadow-sm border border-white/50">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-[#040F16] text-sm">{{ $comment->user->name }}</span>
                                <span class="text-xs text-[#040F16]/40 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            @can('delete', $comment)
                                <button wire:click="deleteComment({{ $comment->id }})" onclick="return confirm('Delete comment?')" class="text-xs text-[#B80C09]/60 hover:text-[#B80C09] font-bold opacity-0 group-hover:opacity-100 transition">Delete</button>
                            @endcan
                        </div>
                        <p class="text-[#040F16]/90 text-sm leading-relaxed">{{ $comment->body }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 opacity-50"><p>No comments yet.</p></div>
            @endforelse
        </div>
    </div>
</div>
