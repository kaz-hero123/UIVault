<div class="space-y-6">
    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-lg shadow border border-gray-200 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="w-full md:w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by title..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" />
        </div>
        <div class="flex flex-wrap gap-3 w-full md:w-auto">
            <!-- Category Filter -->
            <select wire:model.live="category_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <!-- Tag Filter -->
            <select wire:model.live="tag_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2">
                <option value="">All Tags</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grid List -->
    @if($inspirations->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($inspirations as $item)
                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden flex flex-col relative group">
                    <img src="{{ $item->image_url }}" alt="{{ $item->title ?? 'Untitled' }}" class="w-full h-48 object-cover border-b border-gray-100" />
                    
                    <!-- Favorite Toggle Badge -->
                    <button type="button" wire:click="toggleFavorite({{ $item->id }})" class="absolute top-2 right-2 bg-white/90 p-1.5 rounded-full shadow hover:bg-white focus:outline-none z-10">
                        <svg class="w-5 h-5 {{ $item->is_favorite ? 'text-yellow-400 fill-current' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.907c.969 0 1.371 1.24.588 1.81l-3.97 2.883a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.971-2.883a1 1 0 00-1.18 0l-3.97 2.883c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 9.72c-.783-.57-.38-1.81.588-1.81h4.906a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </button>

                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-sm font-semibold text-gray-950 truncate" title="{{ $item->title ?? 'Untitled' }}">
                                    {{ $item->title ?? 'Untitled' }}
                                </h3>
                                @if($item->category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700">
                                        {{ $item->category }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($item->notes)
                                <p class="text-xs text-gray-500 line-clamp-2 mt-1 mb-2">{{ $item->notes }}</p>
                            @endif

                            @if(!empty($item->tags))
                                <div class="flex flex-wrap gap-1 mt-2">
                                    @foreach($item->tags as $tag)
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-normal bg-gray-100 text-gray-600">
                                            #{{ $tag }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <!-- Colors preview -->
                            <div class="flex gap-1">
                                @foreach($item->dominant_colors as $hex)
                                    <span class="w-3.5 h-3.5 rounded-full border border-gray-200" style="background-color: {{ $hex }}" title="{{ $hex }}"></span>
                                @endforeach
                            </div>
                            
                            @if($item->source_url)
                                <a href="{{ $item->source_url }}" target="_blank" class="text-xs font-medium text-indigo-600 hover:underline">
                                    Source
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $inspirations->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg border border-gray-200 shadow">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search query or filters.</p>
        </div>
    @endif
</div>
