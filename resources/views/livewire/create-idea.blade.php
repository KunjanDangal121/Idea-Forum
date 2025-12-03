<div class="max-w-2xl mx-auto py-12 px-4 relative z-10">
    
    <div class="mb-8">
        <a href="{{ route('idea.index') }}" class="inline-flex items-center text-sm font-bold text-white/80 hover:text-white transition duration-200 bg-[#B80C09]/20 px-4 py-2 rounded-full border border-[#B80C09]/30">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Back to Feed
        </a>
    </div>

    <div class="glass bg-white/80 p-10 rounded-3xl shadow-2xl border border-white/40 relative overflow-hidden">
        {{-- Decorative Top Line --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#B80C09] to-[#01BAEF]"></div>

        <h1 class="text-3xl font-bold mb-2 text-[#040F16] text-center tracking-tight">Spark a New Idea</h1>
        <p class="text-center text-[#040F16]/50 mb-10 font-medium">Share your vision with the community.</p>
        
        <form wire:submit.prevent="submitIdea" action="#" method="POST" class="space-y-8" enctype="multipart/form-data">
            <div>
                <label class="block text-sm font-bold text-[#040F16] mb-2 uppercase tracking-wide">Title</label>
                <input wire:model.live="title" type="text" placeholder="In a few words..." class="w-full border-0 bg-white/50 rounded-xl p-4 shadow-inner ring-1 ring-gray-200 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 font-bold transition">
                @error('title') <span class="text-xs text-[#B80C09] mt-2 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-[#040F16] mb-2 uppercase tracking-wide">Description</label>
                <textarea wire:model.live="description" rows="5" placeholder="Describe details..." class="w-full border-0 bg-white/50 rounded-xl p-4 shadow-inner ring-1 ring-gray-200 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 font-medium transition resize-none"></textarea>
                @error('description') <span class="text-xs text-[#B80C09] mt-2 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-[#040F16] mb-2 uppercase tracking-wide">Image (Optional)</label>
                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-[#B80C09]/20 border-dashed rounded-2xl cursor-pointer bg-[#B80C09]/5 hover:bg-[#B80C09]/10 transition group relative overflow-hidden">
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/20 z-10"><span class="text-white font-bold drop-shadow-md">Change Image</span></div>
                    @else
                        <svg class="w-10 h-10 mb-3 text-[#B80C09]/40 group-hover:text-[#B80C09] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p class="text-sm text-[#B80C09]/60 font-bold">Click to upload</p>
                    @endif
                    <input wire:model.live="image" type="file" class="hidden" accept="image/*" />
                </label>
                @error('image') <span class="text-xs text-[#B80C09] mt-2 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-center pt-4">
                <button type="submit" class="w-full bg-[#B80C09] hover:bg-[#8f0907] text-white font-bold py-4 px-8 rounded-xl transition duration-200 shadow-xl hover:shadow-2xl shadow-[#B80C09]/30 transform hover:-translate-y-1 flex items-center justify-center gap-2" wire:loading.attr="disabled">
                    <span>Launch Idea</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </button>
            </div>
        </form>
    </div>
</div>
