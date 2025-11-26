<div class="max-w-6xl mx-auto pt-6 px-4 md:px-6">
    
    {{-- 1. Search and Filter Bar --}}
    <div class="flex items-center space-x-3 mb-6">
        
        {{-- Filter Dropdown --}}
        <select 
            wire:model.live="statusFilter"
            name="category" 
            id="category" 
            class="rounded-xl border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500 w-44"
        >
            <option value="All">All Categories</option>
            {{-- Loop through statuses passed from component --}}
            @foreach ($statuses as $status)
                <option value="{{ $status->name }}">{{ $status->name }}</option>
            @endforeach
        </select>
        
        {{-- Search Input --}}
        <input 
            wire:model.live.debounce.300ms="search" 
            type="search" 
            placeholder="Search ideas by title..." 
            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:ring-blue-500"
        >
    </div>

    {{-- 2. Submit Idea Button --}}
    <div class="mb-8 flex justify-end">
        @auth
            <a href="{{ route('idea.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-xl transition duration-150 ease-in shadow-lg">
                Submit New Idea
            </a>
        @else
             <p class="text-sm text-gray-500">Please log in to submit an idea.</p>
        @endauth
    </div>


    {{-- 3. Idea List --}}
    <div class="space-y-6">
        @forelse ($ideas as $idea)
            <div 
                class="idea-container flex bg-white rounded-xl shadow-md transition duration-150 ease-in hover:shadow-xl"
            >
                
                {{-- VOTE COUNT AND BUTTON --}}
                <div class="border-r border-gray-100 px-6 py-8 flex flex-col items-center flex-shrink-0">
                    
                    <div class="text-2xl font-bold text-gray-800">{{ $idea->votes_count }}</div>
                    <div class="text-gray-500 font-light text-xs uppercase mt-1">Votes</div>
                    
                    {{-- Vote Button with Livewire Logic --}}
                    <button
                        wire:click="vote({{ $idea->id }})"
                        class="w-full font-semibold text-xs uppercase rounded-xl transition duration-150 ease-in px-4 py-2 mt-4 cursor-pointer
                            {{ $idea->isVotedBy(auth()->user()) 
                                ? 'bg-indigo-600 text-white hover:bg-indigo-700' 
                                : 'bg-gray-200 text-gray-600 border border-gray-200 hover:border-gray-400' }}"
                    >
                        {{ $idea->isVotedBy(auth()->user()) ? 'VOTED' : 'VOTE' }}
                    </button>
                </div>

                {{-- IDEA CONTENT --}}
                <div class="flex flex-1 px-4 py-6">
                    <div class="flex-none">
                        {{-- User Avatar --}}
                        <a href="{{ route('idea.show', $idea) }}">
                            <img src="https://i.pravatar.cc/60?img={{ $idea->user_id }}" alt="avatar" class="w-14 h-14 rounded-full border border-gray-200 shadow-sm">
                        </a>
                    </div>
                    
                    <div class="w-full flex flex-col justify-between mx-6">
                        <h4 class="text-xl font-bold">
                            <a href="{{ route('idea.show', $idea) }}" class="hover:text-indigo-600 transition duration-150 ease-in">{{ $idea->title }}</a>
                        </h4>
                        
                        <div class="text-gray-600 mt-3 line-clamp-3">
                            {{ $idea->description }}
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <div class="flex items-center text-xs text-gray-500 font-semibold space-x-2">
                                <div>{{ $idea->created_at->diffForHumans() }}</div>
                                <div>&bull;</div>
                                <div>{{ $idea->user->name }}</div>
                                <div>&bull;</div>
                                
                                {{-- Dynamic Status Tag --}}
                                <div class="bg-green-100 text-green-700 text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 flex items-center justify-center shadow-sm">
                                    {{ $idea->status->name }}
                                </div>
                            </div>
                            
                            {{-- Comment Count --}}
                            <div class="flex items-center text-xs font-semibold text-gray-500">
                                <a href="{{ route('idea.show', $idea) . '#comments' }}" class="hover:text-gray-900 transition duration-150 ease-in">
                                    {{ $idea->comments_count }} comments
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-10 text-gray-500 bg-white border rounded-lg">
                No ideas found matching your search.
            </div>
        @endforelse
    </div>

    {{-- 4. Pagination --}}
    <div class="mt-8">
        {{ $ideas->links() }}
    </div>
</div>
