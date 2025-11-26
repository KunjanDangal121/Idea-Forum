<div class="show-idea-wrapper max-w-4xl mx-auto py-6 px-4"> {{-- START: SINGLE ROOT ELEMENT --}}

    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ route('idea.index') }}" class="text-sm text-gray-500 hover:text-blue-500">&lt; All Ideas</a>
    </div>

    {{-- IDEA DETAIL CARD BLOCK --}}
    <div class="bg-white border rounded-lg shadow-sm p-8 flex space-x-6">
        
        {{-- Vote Count Section (Always visible) --}}
        <div class="text-center px-4 py-2 bg-gray-100 rounded-xl flex-shrink-0">
            <div class="text-2xl font-bold text-gray-800">{{ $idea->votes()->count() }}</div>
            <div class="text-xs text-gray-500">Votes</div>
        </div>

        <div class="flex-1">
            
            {{-- 1. EDIT FORM VIEW --}}
            @if ($isEditing)
                <form wire:submit.prevent="updateIdea" class="w-full">
                    <div class="mb-4">
                        <label for="editedTitle" class="block text-sm font-medium text-gray-700">Title</label>
                        <input wire:model.defer="editedTitle" type="text" id="editedTitle" class="w-full p-2 border rounded" required>
                        @error('editedTitle') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label for="editedDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model.defer="editedDescription" id="editedDescription" rows="6" class="w-full p-2 border rounded resize-none" required></textarea>
                        @error('editedDescription') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button wire:click.prevent="cancelEdit" type="button" class="bg-gray-300 text-gray-700 px-3 py-1 text-sm rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 text-sm rounded hover:bg-blue-700">Update Idea</button>
                    </div>
                </form>
            @endif

            {{-- 2. STATIC VIEW (Visible unless editing) --}}
            @unless ($isEditing)
                <h1 class="text-2xl font-bold mb-2">{{ $idea->title }}</h1>
                
                <div class="text-gray-600 mb-4">
                    {{ $idea->description }}
                </div>

                <div class="mt-4 text-sm text-gray-400">
                    Posted by {{ $idea->user->name }} • {{ $idea->created_at->diffForHumans() }}
                </div>
                
                {{-- Action Buttons --}}
                <div class="mt-4 space-x-2">
                    @can('update', $idea)
                        <button 
                            wire:click="startEdit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 text-sm rounded transition"
                        >
                            Edit
                        </button>
                        <button 
                            wire:click="deleteIdea" 
                            onclick="return confirm('Are you absolutely sure you want to delete this idea? This cannot be undone.')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-sm rounded transition"
                        >
                            Delete
                        </button>
                    @endcan
                </div>
            @endunless

        </div>
    </div>

    {{-- NEW: ADMIN STATUS UPDATE DROPDOWN (Only visible to Admin ID 12) --}}
    @if (auth()->id() === 12)
        <div class="mt-8 mb-6 p-4 bg-white border rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold mb-3">Admin Controls</h3>
            <div class="flex items-center space-x-4">
                <label for="status_update" class="text-sm font-medium text-gray-700">Change Status:</label>
                <select 
                    id="status_update" 
                    class="rounded-lg border-gray-300 text-sm py-2 focus:ring-blue-500"
                    wire:change="updateStatus($event.target.value)"
                >
                    @foreach ($statuses as $status)
                        <option 
                            value="{{ $status->id }}" 
                            @if ($status->id === $idea->status_id) selected @endif
                        >
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    {{-- COMMENTS SECTION --}}
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">
    {{-- COMMENTS SECTION (Always visible) --}}
    {{-- Added id="comments" here --}}
<div id="comments" class="mt-10"> 
    <h2 class="text-xl font-semibold mb-4">
            Comments ({{ $comments->count() }})
        </h2>

        {{-- COMMENT FORM START --}}
        @auth
            <div class="p-4 mb-8 bg-white border rounded-lg shadow-md">
                <form wire:submit.prevent="postComment" action="#" method="POST">
                    <textarea 
                        wire:model.live="newComment" 
                        name="newComment" 
                        rows="3" 
                        placeholder="Share your thoughts on this idea..."
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500 text-gray-700 resize-none"
                    ></textarea>
                    
                    @error('newComment') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror

                    <div class="flex justify-end mt-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out duration-150">
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="text-center p-4 mb-8 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">Please <a href="/login" class="font-bold underline">log in</a> to post a comment.</p>
            </div>
        @endauth

        {{-- Comment Loop --}}
        <div class="space-y-6">
            @forelse ($comments as $comment)
                <div class="p-4 bg-white border rounded-lg shadow-sm">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">{{ $comment->user->name }}</span>
                        
                        {{-- DELETE BUTTON --}}
                        @can('delete', $comment)
                            <button 
                                wire:click="deleteComment({{ $comment->id }})" 
                                onclick="return confirm('Are you sure you want to delete this comment?')"
                                class="text-xs text-red-500 hover:text-red-700 transition"
                            >
                                Delete
                            </button>
                        @endcan
                        
                        <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-2 text-gray-700">
                        {{ $comment->body }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500 text-center p-4">No comments yet. Be the first!</p>
            @endforelse
        </div>
    </div>

</div>
