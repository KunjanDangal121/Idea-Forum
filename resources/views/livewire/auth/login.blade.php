<x-guest-layout>
    {{-- Ambient Background Blobs --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[60%] h-[60%] rounded-full bg-[#B80C09]/20 blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] rounded-full bg-[#0B4F6C]/20 blur-[120px]"></div>
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

        {{-- Glass Card --}}
        <div class="max-w-4xl w-full flex flex-col md:flex-row bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl overflow-hidden border border-white/60">
            
            {{-- LEFT SIDE: LOGIN FORM --}}
            <div class="w-full md:w-1/2 p-8 md:p-12 relative">
                <div class="text-center mb-8">
                    <a href="/" class="flex justify-center items-center gap-2 mb-4 group">
                        <svg class="w-10 h-10 text-[#B80C09] drop-shadow-md group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="text-3xl font-bold text-[#040F16] tracking-tight">Spark</span>
                    </a>
                    <h2 class="text-2xl font-bold text-[#040F16]">Welcome Back</h2>
                    <p class="text-sm text-[#040F16]/60 mt-2 font-medium">Sign in to ignite your next idea.</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-[#040F16] mb-2 uppercase tracking-wide">Email</label>
                        <input id="email" class="block w-full rounded-xl border-0 bg-white/60 p-4 text-[#040F16] shadow-inner ring-1 ring-[#0B4F6C]/10 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 transition" 
                               type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#B80C09]" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-[#040F16] mb-2 uppercase tracking-wide">Password</label>
                        <input id="password" class="block w-full rounded-xl border-0 bg-white/60 p-4 text-[#040F16] shadow-inner ring-1 ring-[#0B4F6C]/10 focus:ring-2 focus:ring-[#B80C09] placeholder-gray-400 transition" 
                               type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#B80C09]" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#B80C09] shadow-sm focus:ring-[#B80C09] bg-white/50" name="remember">
                            <span class="ml-2 text-sm text-[#040F16]/70 font-medium group-hover:text-[#B80C09] transition">Remember me</span>
                        </label>

                        <button type="button" onclick="alert('Please contact the admin of this page.')" class="text-sm font-bold text-[#B80C09] hover:text-[#8f0907] transition duration-200 underline decoration-[#B80C09]/30 hover:decoration-[#B80C09]">
                            Forgot password?
                        </button>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-[#B80C09]/20 text-sm font-bold text-white bg-[#B80C09] hover:bg-[#8f0907] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#B80C09] transition duration-200 transform hover:-translate-y-0.5">
                        Log in
                    </button>
                </form>
            </div>

            {{-- RIGHT SIDE: REGISTER PROMPT --}}
            <div class="w-full md:w-1/2 bg-[#B80C09]/90 backdrop-blur-md p-8 md:p-12 flex flex-col justify-center items-center text-center relative overflow-hidden">
                <div class="absolute top-[-20%] right-[-20%] w-80 h-80 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-60 h-60 rounded-full bg-[#040F16]/20 blur-2xl"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl font-bold text-white mb-4">New here?</h2>
                    <p class="text-white/80 mb-8 max-w-xs mx-auto text-lg leading-relaxed font-medium">
                        Join Spark to share your ideas, vote on others, and help shape the future.
                    </p>
                    <a href="{{ route('register') }}" class="inline-block bg-white text-[#B80C09] font-bold py-3 px-8 rounded-xl transition duration-200 ease-in-out shadow-xl hover:shadow-2xl hover:bg-gray-50 transform hover:-translate-y-0.5 border border-white/50">
                        Create an Account
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
