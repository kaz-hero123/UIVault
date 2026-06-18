<div class="bg-white p-6 rounded-lg shadow border border-gray-200">
    @if($current)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Side: Image and colors -->
            <div>
                <img src="{{ \Illuminate\Support\Facades\Storage::url($current->image_path) }}" alt="Preview" class="max-w-full h-auto rounded border border-gray-300 shadow-sm" />
                <div class="mt-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Dominant Colors:</span>
                    <div class="flex gap-2 mt-1">
                        @foreach($current->dominant_colors ?? [] as $hex)
                            <div class="w-8 h-8 rounded-full border border-gray-300" style="background-color: {{ $hex }}" title="{{ $hex }}"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Side: Sorter Form -->
            <form wire:submit.prevent="sort" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" wire:model="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" placeholder="e.g., Homepage Redesign" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select wire:model="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                        <option value="">Select Category...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tags (comma-separated)</label>
                    <input type="text" wire:model="tagsInput" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" placeholder="e.g., dashboard, light mode" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea wire:model="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" placeholder="Write any notes..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Source URL</label>
                    <input type="url" wire:model="source_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" placeholder="https://example.com" />
                </div>

                <div class="flex items-center">
                    <button type="button" wire:click="toggleFavorite" class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <svg class="w-6 h-6 {{ $is_favorite ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.969 0 1.371 1.24.588 1.81l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.883a1 1 0 00-1.18 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 9.72c-.783-.57-.38-1.81.588-1.81h4.906a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Favorite
                    </button>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <span class="text-sm text-gray-500">{{ $remainingCount }} items left in inbox</span>
                    <div class="flex gap-2">
                        <button type="button" wire:click="skip" class="px-4 py-2 border border-gray-300 rounded shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Skip
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Sort
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">All caught up!</h3>
            <p class="mt-1 text-sm text-gray-500">Inbox is empty. Upload some images to get started sorting.</p>
        </div>
    @endif
</div>
