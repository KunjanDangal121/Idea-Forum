<div class="max-w-2xl mx-auto py-12 px-4 relative z-10">
    
    {{-- NEW: Back Button --}}
    <div class="mb-8">
        <a href="{{ route('idea.index') }}" class="inline-flex items-center text-sm font-bold text-[#0B4F6C]/60 hover:text-[#01BAEF] transition duration-200 group bg-white/50 px-4 py-2 rounded-full backdrop-blur-sm shadow-sm hover:shadow-md border border-white/60">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Feed
        </a>
    </div>

    {{-- Main Glass Card --}}
    <div class="glass bg-white/80 p-10 rounded-3xl shadow-2xl border border-white/40 relative overflow-hidden">
        
        {{-- Decorative Top Line --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#B80C09] to-[#01BAEF]"></div>

        <h1 class="text-3xl font-bold mb-8 text-[#040F16] text-center tracking-tight">Profile Settings</h1>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl font-bold flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="updateProfile" class="space-y-8">
            
            {{-- PHOTO UPLOAD --}}
            <div class="flex flex-col sm:flex-row items-center gap-8 p-6 bg-[#FBFBFF]/80 rounded-2xl border border-[#0B4F6C]/5">
                <div class="shrink-0 relative group">
                    @if ($photo)
                        <img src="{{ $photo->temporaryUrl() }}" class="h-28 w-28 object-cover rounded-full border-4 border-white shadow-lg group-hover:scale-105 transition duration-300">
                    @else
                        <img src="{{ auth()->user()->getAvatar() }}" class="h-28 w-28 object-cover rounded-full border-4 border-white shadow-lg group-hover:scale-105 transition duration-300">
                    @endif
                    <div class="absolute inset-0 rounded-full border-2 border-[#0B4F6C]/10 pointer-events-none"></div>
                </div>
                
                <label class="block w-full">
                    <span class="sr-only">Choose profile photo</span>
                    <div class="flex flex-col gap-2">
                        <span class="text-sm font-bold text-[#040F16] uppercase tracking-wide">Profile Photo</span>
                        <input wire:model.live="photo" type="file" class="block w-full text-sm text-[#0B4F6C]
                            file:mr-4 file:py-2.5 file:px-6
                            file:rounded-full file:border-0
                            file:text-xs file:font-bold
                            file:bg-[#0B4F6C] file:text-white
                            hover:file:bg-[#093e55]
                            cursor-pointer transition
                        "/>
                        <span class="text-xs text-[#0B4F6C]/50 font-medium">JPG, PNG or GIF (Max 1MB)</span>
                    </div>
                    @error('photo') <span class="text-xs text-[#B80C09] mt-2 block font-bold">{{ $message }}</span> @enderror
                </label>
            </div>

            {{-- NAME --}}
            <div>
                <label class="block text-sm font-bold text-[#040F16] mb-2 uppercase tracking-wide">Display Name</label>
                <input wire:model="name" type="text" class="w-full border-0 bg-white/50 rounded-xl p-4 shadow-inner ring-1 ring-gray-200 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 font-bold text-[#040F16] transition">
                @error('name') <span class="text-xs text-[#B80C09] mt-2 block font-bold">{{ $message }}</span> @enderror
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-bold text-[#040F16] mb-2 uppercase tracking-wide">Email Address</label>
                <input wire:model="email" type="email" class="w-full border-0 bg-white/50 rounded-xl p-4 shadow-inner ring-1 ring-gray-200 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 font-bold text-[#040F16] transition">
                @error('email') <span class="text-xs text-[#B80C09] mt-2 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-6 border-t border-[#0B4F6C]/10">
                <button type="submit" class="bg-[#B80C09] hover:bg-[#8f0907] text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl shadow-[#B80C09]/20 transform hover:-translate-y-0.5 transition duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
