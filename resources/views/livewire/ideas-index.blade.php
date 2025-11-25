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
                No ideas found in the database.
            </div>
        @endforelse
    </div>
