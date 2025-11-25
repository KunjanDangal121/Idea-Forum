<div class="max-w-4xl mx-auto py-6 px-4">
    
    <h1 class="text-3xl font-bold mb-6">All Ideas</h1>

    {{-- Create Post Button (EXISTING) --}}
    <div class="mb-6 flex justify-end">
        @auth
            <a href="{{ route('idea.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                Submit New Idea
            </a>
        @else
             <p class="text-sm text-gray-500">Log in to submit an idea.</p>
        @endauth
    </div>

    {{-- NEW: SEARCH AND FILTER BAR --}}
    <div class="flex space-x-4 mb-8">
        
        {{-- Search Input (Bound to $search property in the component) --}}
        <input 
            wire:model.live.debounce.300ms="search" 
            type="search" 
            placeholder="Search ideas by title..."
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500"
        >

        {{-- Filter Dropdown (Bound to $statusFilter property) --}}
        <select 
            wire:model.live="statusFilter"
            class="border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500 flex-shrink-0"
        >
            <option value="All">All Ideas</option>
            <option value="Open">Open</option>
            <option value="Complete">Complete</option>
        </select>
    </div>

    {{-- Idea List Starts Here --}}
    <div class="space-y-4">
        @forelse ($ideas as $idea)
            <div class="p-6 bg-white border rounded-lg shadow-sm flex space-x-4">
                {{-- Vote Count --}}
                <div class="text-center px-4 py-2 bg-gray-100 rounded-xl">
                    <div class="text-2xl font-bold text-blue-500">{{ $idea->votes_count }}</div>
                    <div class="text-xs text-gray-500">Votes</div>
                </div>

                {{-- Idea Content --}}
                <div class="flex-1">
                    <h2 class="text-xl font-semibold">
                    <a href="{{ route('idea.show', $idea) }}" class="hover:underline">{{ $idea->title }}</a>
                    </h2>
                    <p class="text-gray-600 mt-2 line-clamp-3">
                        {{ $idea->description }}
                    </p>
                    <div class="mt-4 text-sm text-gray-400">
                        Posted by {{ $idea->user->name }} • {{ $idea->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-10 text-gray-500 bg-white border rounded-lg">
                No ideas found matching your search.
            </div>
        @endforelse
    </div>

    {{-- Pagination Links --}}
    <div class="mt-6">
        {{ $ideas->links() }}
    </div>
</div>
