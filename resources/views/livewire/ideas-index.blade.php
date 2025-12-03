<div class="relative">
    
    {{-- HERO BANNER (Simple Welcome) --}}
    <div class="relative w-full bg-gradient-to-b from-[#B80C09]/10 to-transparent py-10 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-[#040F16] mb-2 drop-shadow-sm">Be The Spark That Starts The Fire</h1>
            <p class="text-[#040F16]/60 text-lg font-medium">Join the discussion and help shape the future.</p>
        </div>
    </div>

    {{-- MAIN CONTENT GRID --}}
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8 pb-12">
        
        {{-- LEFT SIDEBAR: Filters --}}
        <div class="md:col-span-1">
            <div class="sticky top-28 space-y-6">
                
                {{-- Submit Button --}}
                @auth
                    <a href="{{ route('idea.create') }}" class="w-full flex items-center justify-center gap-2 bg-[#B80C09] hover:bg-[#8f0907] text-white font-bold py-3.5 px-6 rounded-2xl transition duration-200 shadow-lg shadow-[#B80C09]/20 hover:shadow-xl hover:-translate-y-0.5 border border-white/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Add Idea</span>
                    </a>
                @endauth

                {{-- Topics Menu --}}
                <div class="glass bg-white/50 rounded-2xl p-4 shadow-sm border border-white/40">
                    <h3 class="font-bold text-[#040F16]/80 mb-3 px-2 text-sm uppercase tracking-wider flex justify-between items-center">
                        <span>Topics</span>
                        @if(auth()->check() && auth()->user()->email === 'kunjandangal@gmail.com')
                            <span class="text-[10px] bg-[#B80C09] text-white px-2 py-0.5 rounded-full">Admin</span>
                        @endif
                    </h3>
                    
                    <nav class="space-y-1 max-h-[60vh] overflow-y-auto pr-1 scrollbar-thin">
                        <button wire:click="$set('statusFilter', 'All')" class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-xl transition duration-200 {{ $statusFilter === 'All' ? 'bg-[#B80C09]/10 text-[#B80C09] font-bold' : 'text-[#040F16]/70 hover:bg-white/60' }}">
                            <span class="w-2 h-2 rounded-full {{ $statusFilter === 'All' ? 'bg-[#B80C09]' : 'bg-gray-300' }}"></span>
                            <span>All Topics</span>
                        </button>
                        @foreach ($statuses as $status)
                            <button wire:click="$set('statusFilter', '{{ $status->name }}')" class="w-full text-left flex items-center gap-3 px-3 py-2.5 rounded-xl transition duration-200 {{ $statusFilter === $status->name ? 'bg-[#B80C09]/10 text-[#B80C09] font-bold' : 'text-[#040F16]/70 hover:bg-white/60' }}">
                                <span class="w-2 h-2 rounded-full {{ $statusFilter === $status->name ? 'bg-[#B80C09]' : 'bg-gray-300' }}"></span>
                                <span>{{ $status->name }}</span>
                            </button>
                        @endforeach
                    </nav>

                    {{-- ADMIN ADD TOPIC FORM --}}
                    @if(auth()->check() && auth()->user()->email === 'kunjandangal@gmail.com')
                        <div class="mt-4 pt-4 border-t border-gray-200/50">
                            <form wire:submit.prevent="addTopic" class="relative">
                                <input wire:model="newTopic" type="text" placeholder="+ New Topic" class="w-full bg-white/50 border border-gray-200 rounded-lg py-2 pl-3 pr-8 text-sm focus:ring-1 focus:ring-[#B80C09] focus:border-[#B80C09] placeholder-gray-400">
                                <button type="submit" class="absolute right-2 top-2 text-[#B80C09] hover:text-[#040F16]">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            </form>
                            @error('newTopic') <span class="text-xs text-[#B80C09] mt-1">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- FEED --}}
        <div class="md:col-span-3 space-y-6">
            @forelse ($ideas as $idea)
                <div class="glass bg-white/70 rounded-2xl p-6 shadow-sm hover:shadow-xl transition duration-300 border border-white/40 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('idea.show', $idea) }}" class="flex-shrink-0">
                                <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                            </a>
                            <div>
                                <div class="font-bold text-[#040F16] text-sm">{{ $idea->user->name }}</div>
                                <div class="text-[#0B4F6C]/50 text-xs font-semibold">{{ $idea->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="px-3 py-1 rounded-full text-xs font-bold bg-[#FBFBFF] text-[#B80C09] border border-[#B80C09]/10 shadow-sm">
                            {{ $idea->status->name }}
                        </div>
                    </div>

                    <div class="mb-5 pl-13">
                        @if ($idea->image)
                            <div class="mb-4 overflow-hidden rounded-xl border border-white/50 shadow-inner">
                                <a href="{{ route('idea.show', $idea) }}">
                                    <img src="{{ Storage::url($idea->image) }}" alt="Idea Image" class="w-full h-56 object-cover hover:scale-105 transition duration-500">
                                </a>
                            </div>
                        @endif

                        <h2 class="text-xl font-bold text-[#040F16] mb-2 leading-snug group-hover:text-[#B80C09] transition-colors">
                            <a href="{{ route('idea.show', $idea) }}">{{ $idea->title }}</a>
                        </h2>
                        <p class="text-[#040F16]/70 text-sm leading-relaxed line-clamp-3 cursor-pointer" onclick="window.location='{{ route('idea.show', $idea) }}'">
                            {{ $idea->description }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 pl-13">
                        <button wire:click="vote({{ $idea->id }})" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold transition duration-200 border {{ $idea->isVotedBy(auth()->user()) ? 'bg-[#B80C09] text-white border-[#B80C09] shadow-md' : 'bg-white/50 text-[#040F16]/60 border-white/60 hover:bg-white hover:text-[#B80C09] hover:shadow-sm' }}">
                            <svg class="w-5 h-5" fill="{{ $idea->isVotedBy(auth()->user()) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" /></svg>
                            <span>{{ $idea->votes_count }}</span>
                        </button>
                        <a href="{{ route('idea.show', $idea) . '#comments' }}" class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold text-[#040F16]/60 hover:bg-white/80 hover:text-[#040F16] transition duration-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            <span>{{ $idea->comments_count }}</span>
                        </a>
                    </div>
                </div>
            @empty
                <div class="glass bg-white/50 rounded-2xl p-12 text-center border-dashed border-2 border-[#B80C09]/20">
                    <h3 class="text-lg font-bold text-[#040F16]">No ideas yet</h3>
                    <p class="text-[#040F16]/60">Be the spark that starts the fire.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 pb-12">
        {{ $ideas->links() }}
    </div>
</div>
