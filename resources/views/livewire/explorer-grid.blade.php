<div class="space-y-4">

    {{-- Filters --}}
    <div class="bg-white p-4 rounded shadow flex flex-col md:flex-row gap-3 items-start md:items-center">
        {{-- Search --}}
        <div class="flex-1 w-full">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari judul..."
                class="w-full border border-gray-300 rounded p-2 text-sm"
            />
        </div>

        {{-- Category Filter --}}
        <div>
            <select wire:model.live="category_id" class="border border-gray-300 rounded p-2 text-sm">
                <option value="">Semua Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tag Filter --}}
        <div>
            <select wire:model.live="tag_id" class="border border-gray-300 rounded p-2 text-sm">
                <option value="">Semua Tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Results Grid --}}
    @if($inspirations->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($inspirations as $item)
                <div class="bg-white rounded shadow overflow-hidden border">
                    {{-- Image --}}
                    <img src="{{ $item->image_url }}" alt="{{ $item->title ?? 'Untitled' }}" class="w-full h-40 object-cover" />

                    <div class="p-3">
                        {{-- Title + Favorite --}}
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-sm font-semibold text-gray-900 truncate" title="{{ $item->title }}">
                                {{ $item->title ?? 'Untitled' }}
                            </h3>
                            <button wire:click="toggleFavorite({{ $item->id }})" class="text-lg leading-none" title="Toggle Favorite">
                                {!! $item->is_favorite ? '<span class="text-yellow-500">★</span>' : '<span class="text-gray-300">☆</span>' !!}
                            </button>
                        </div>

                        {{-- Category Badge --}}
                        @if($item->category)
                            <span class="inline-block text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded mb-1">{{ $item->category }}</span>
                        @endif

                        {{-- Tags --}}
                        @if(!empty($item->tags))
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach($item->tags as $tagName)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded">#{{ $tagName }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Notes --}}
                        @if($item->notes)
                            <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ $item->notes }}</p>
                        @endif

                        {{-- Bottom: Colors + Source --}}
                        <div class="flex items-center justify-between mt-2 pt-2 border-t">
                            <div class="flex gap-1">
                                @foreach($item->dominant_colors as $hex)
                                    <span class="w-3 h-3 rounded-full border border-gray-200 inline-block" style="background-color: {{ $hex }}" title="{{ $hex }}"></span>
                                @endforeach
                            </div>
                            @if($item->source_url)
                                <a href="{{ $item->source_url }}" target="_blank" class="text-xs text-indigo-600 hover:underline">Source ↗</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $inspirations->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded shadow text-center py-12 text-gray-500">
            <p class="text-2xl mb-2">🔍</p>
            <p class="font-medium">Tidak ada hasil</p>
            <p class="text-sm mt-1">Coba ubah pencarian atau filter kamu.</p>
        </div>
    @endif
</div>
