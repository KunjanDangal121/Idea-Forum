<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-[#FBFBFF] leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-[#01BAEF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-[#FBFBFF] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- WELCOME CARD --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-[#0B4F6C]/10 mb-8">
                <div class="p-8 text-[#040F16]">
                    <h3 class="text-2xl font-bold text-[#0B4F6C] mb-2">Welcome back, {{ auth()->user()->name }}! ⚡</h3>
                    <p class="text-[#040F16]/70">
                        You are logged in to <span class="font-bold text-[#01BAEF]">Spark</span>. manage your account settings or jump back into the discussion below.
                    </p>
                </div>
            </div>

            {{-- ACTION GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Action 1: Browse Ideas --}}
                <a href="{{ route('idea.index') }}" class="group block bg-white p-6 rounded-2xl shadow-md border border-[#0B4F6C]/5 hover:border-[#01BAEF] transition duration-200 ease-in-out hover:shadow-xl transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-[#0B4F6C]/5 rounded-xl group-hover:bg-[#01BAEF]/10 transition">
                            <svg class="w-8 h-8 text-[#0B4F6C] group-hover:text-[#01BAEF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#01BAEF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-[#040F16] mb-1">Browse Ideas</h4>
                    <p class="text-sm text-[#0B4F6C]/60">View the latest suggestions, vote, and comment.</p>
                </a>

                {{-- Action 2: Submit Idea --}}
                <a href="{{ route('idea.create') }}" class="group block bg-white p-6 rounded-2xl shadow-md border border-[#0B4F6C]/5 hover:border-[#01BAEF] transition duration-200 ease-in-out hover:shadow-xl transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-[#0B4F6C]/5 rounded-xl group-hover:bg-[#01BAEF]/10 transition">
                            <svg class="w-8 h-8 text-[#0B4F6C] group-hover:text-[#01BAEF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#01BAEF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-[#040F16] mb-1">Submit New Idea</h4>
                    <p class="text-sm text-[#0B4F6C]/60">Got a spark? Share your suggestion with the community.</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
