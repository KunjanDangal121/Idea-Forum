<div class="max-w-xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Submit a New Idea</h1>

    <div class="bg-white p-6 rounded-lg shadow-xl border">
        
        <form wire:submit.prevent="submitIdea" action="#" method="POST">
            
            {{-- IDEA TITLE --}}
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Idea Title</label>
                <input 
                    wire:model.live="title" 
                    type="text" 
                    id="title" 
                    placeholder="Short, descriptive title (max 100 chars)"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                >
                @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- IDEA DESCRIPTION --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea 
                    wire:model.live="description" 
                    id="description" 
                    rows="6" 
                    placeholder="Describe your idea in detail..."
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                ></textarea>
                @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    Submit Idea
                </button>
            </div>
        </form>
    </div>
</div>
