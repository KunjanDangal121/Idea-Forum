<div class="max-w-4xl mx-auto py-6 px-4">
    
    {{-- Back Button Placeholder --}}
    <div class="mb-4">
        <a href="{{ route('idea.index') }}" class="text-sm text-gray-500 hover:text-blue-500">&lt; All Ideas</a>
    </div>

    {{-- IDEA DETAIL CARD --}}
    <div class="bg-white border rounded-lg shadow-sm p-8 flex space-x-6">
        
        {{-- Vote Count Section (Reusing Index Logic) --}}
        <div class="text-center px-4 py-2 bg-gray-100 rounded-xl flex-shrink-0">
            <div class="text-2xl font-bold text-blue-500">{{ $idea->votes()->count() }}</div>
            <div class="text-xs text-gray-500">Votes</div>
        </div>

        {{-- Idea Content --}}
        <div class="flex-1">
            <h1 class="text-2xl font-bold mb-2">{{ $idea->title }}</h1>
            
            <div class="text-gray-600 mb-4">
                {{ $idea->description }}
            </div>

            <div class="mt-4 text-sm text-gray-400">
                Posted by {{ $idea->user->name }} • {{ $idea->created_at->diffForHumans() }}
            </div>
            
            {{-- Action Buttons Placeholder (For your friend to style later) --}}
            <div class="mt-4 space-x-2">
                <button class="bg-blue-500 text-white px-3 py-1 text-sm rounded">Edit</button>
                <button class="bg-red-500 text-white px-3 py-1 text-sm rounded">Delete</button>
            </div>
        </div>
    </div>

    {{-- COMMENTS SECTION --}}
    <div class="mt-10">
        <h2 class="text-xl font-semibold mb-4">
            Comments ({{ $comments->count() }})
        </h2>

        {{-- NEW: COMMENT FORM START --}}
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
                    
                    @error('newComment') 
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> 
                    @enderror

                    <div class="flex justify-end mt-3">
                        <button 
                            type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out duration-150"
                        >
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
        {{-- END COMMENT FORM --}}

        {{-- Comment Loop --}}
        <div class="space-y-6">
            @forelse ($comments as $comment)
                <div class="p-4 bg-white border rounded-lg shadow-sm">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">{{ $comment->user->name }}</span>
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
