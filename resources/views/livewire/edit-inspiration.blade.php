<div class="bg-white p-6 rounded shadow border">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- LEFT: Image Preview --}}
        <div>
            <img
                src="{{ \Illuminate\Support\Facades\Storage::url($inspiration->image_path) }}"
                alt="Preview"
                class="w-full rounded border"
            />

            {{-- Dominant Colors --}}
            @if(!empty($inspiration->dominant_colors))
                <div class="mt-3">
                    <span class="text-xs text-gray-500 font-semibold">Dominant Colors:</span>
                    <div class="flex gap-1 mt-1">
                        @foreach($inspiration->dominant_colors as $hex)
                            <div
                                class="w-6 h-6 rounded border border-gray-300"
                                style="background-color: {{ $hex }}"
                                title="{{ $hex }}"
                            ></div>
                        @endforeach
                    </div>
                </div>
            @endif

            <p class="text-xs text-gray-400 mt-2">ID: {{ $inspiration->id }} &middot; Status: {{ $inspiration->status }}</p>
        </div>

        {{-- RIGHT: Edit Form --}}
        <div>
            <form wire:submit.prevent="save" class="space-y-3">

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" wire:model="title" class="mt-1 w-full border border-gray-300 rounded p-2 text-sm" placeholder="Judul gambar..." />
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select wire:model="category_id" class="mt-1 w-full border border-gray-300 rounded p-2 text-sm">
                        <option value="">-- Pilih Category --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tags --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tags (pisahkan koma)</label>
                    <input type="text" wire:model="tagsInput" list="existing-tags" class="mt-1 w-full border border-gray-300 rounded p-2 text-sm" placeholder="dashboard, dark mode, mobile" />
                    <datalist id="existing-tags">
                        @foreach($existingTags as $tag)
                            <option value="{{ $tag }}"></option>
                        @endforeach
                    </datalist>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea wire:model="notes" rows="2" class="mt-1 w-full border border-gray-300 rounded p-2 text-sm" placeholder="Catatan opsional..."></textarea>
                </div>

                {{-- Source URL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Source URL</label>
                    <input type="url" wire:model="source_url" class="mt-1 w-full border border-gray-300 rounded p-2 text-sm" placeholder="https://dribbble.com/..." />
                </div>

                {{-- Favorite Toggle --}}
                <div class="flex items-center gap-2">
                    <button type="button" wire:click="$toggle('is_favorite')" class="text-sm flex items-center gap-1 font-medium text-gray-700">
                        @if($is_favorite)
                            <span class="text-yellow-500 text-lg">★</span> <span class="text-indigo-650">Favorited</span>
                        @else
                            <span class="text-gray-400 text-lg">☆</span> <span class="text-gray-500">Not Favorite</span>
                        @endif
                    </button>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t">
                    <a href="{{ route('explorer') }}" class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-650 text-white rounded text-sm font-medium hover:bg-indigo-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
