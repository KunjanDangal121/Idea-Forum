<x-guest-layout>
    {{-- Ambient Background Blobs --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute bottom-[-10%] left-[-10%] w-[60%] h-[60%] rounded-full bg-[#B80C09]/20 blur-[120px]"></div>
        <div class="absolute top-[-10%] right-[-10%] w-[60%] h-[60%] rounded-full bg-[#0B4F6C]/20 blur-[120px]"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative z-10">
        
        {{-- NEW: Back Button --}}
        <div class="absolute top-6 left-6 md:top-10 md:left-10 z-20">
            <a href="/" class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/40 hover:bg-white/60 text-[#040F16] font-bold text-sm backdrop-blur-md border border-white/50 transition duration-200 shadow-sm hover:shadow-md group">
                <svg class="w-4 h-4 text-[#B80C09] group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Home
            </a>
        </div>

        <div class="max-w-4xl w-full flex flex-col md:flex-row bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl overflow-hidden border border-white/60">
            
            {{-- LEFT SIDE: REGISTRATION FORM --}}
            <div class="w-full md:w-1/2 p-8 md:p-12 relative">
                <div class="text-center mb-8">
                    <a href="/" class="flex justify-center items-center gap-2 mb-4 group">
                        <svg class="w-10 h-10 text-[#B80C09] drop-shadow-md group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="text-3xl font-bold text-[#040F16] tracking-tight">Spark</span>
                    </a>
                    <h2 class="text-2xl font-bold text-[#040F16]">Create Account</h2>
                    <p class="text-sm text-[#040F16]/60 mt-2 font-medium">Join the community and start sparking.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-bold text-[#040F16]/70 mb-1 uppercase tracking-wider">Full Name</label>
                        <input id="name" class="block w-full rounded-xl border-0 bg-white/60 p-3 text-[#040F16] shadow-inner ring-1 ring-[#0B4F6C]/10 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 transition" 
                               type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-[#B80C09] font-bold" />
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-[#040F16]/70 mb-1 uppercase tracking-wider">Email</label>
                        <input id="email" class="block w-full rounded-xl border-0 bg-white/60 p-3 text-[#040F16] shadow-inner ring-1 ring-[#0B4F6C]/10 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 transition" 
                               type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-[#B80C09] font-bold" />
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-[#040F16]/70 mb-1 uppercase tracking-wider">Password</label>
                        <input id="password" class="block w-full rounded-xl border-0 bg-white/60 p-3 text-[#040F16] shadow-inner ring-1 ring-[#0B4F6C]/10 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 transition" 
                               type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-[#B80C09] font-bold" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-[#040F16]/70 mb-1 uppercase tracking-wider">Confirm Password</label>
                        <input id="password_confirmation" class="block w-full rounded-xl border-0 bg-white/60 p-3 text-[#040F16] shadow-inner ring-1 ring-[#0B4F6C]/10 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 transition" 
                               type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-[#B80C09] font-bold" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-[#B80C09]/20 text-sm font-bold text-white bg-[#B80C09] hover:bg-[#8f0907] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B80C09] transition duration-200 transform hover:-translate-y-0.5">
                            Register
                        </button>
                    </div>
                </form>
            </div>

            {{-- RIGHT SIDE: LOGIN PROMPT --}}
            <div class="w-full md:w-1/2 bg-[#040F16]/95 backdrop-blur-md p-8 md:p-12 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div class="absolute top-[-10%] left-[-10%] w-60 h-60 rounded-full bg-[#B80C09]/30 blur-3xl"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-60 h-60 rounded-full bg-[#0B4F6C]/30 blur-3xl"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-white mb-4">Already a member?</h2>
                    <p class="text-white/70 mb-8 max-w-xs mx-auto text-lg leading-relaxed font-medium">
                        Welcome back! Log in to continue voting and commenting on your favorite ideas.
                    </p>
                    <a href="{{ route('login') }}" class="inline-block bg-white/10 hover:bg-white/20 text-white border border-white/30 font-bold py-3 px-8 rounded-xl transition duration-200 ease-in-out backdrop-blur-sm transform hover:-translate-y-0.5">
                        Log In
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
