<div class="bg-white p-6 rounded shadow">
    @if($current)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- LEFT: Image Preview --}}
            <div>
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::url($current->image_path) }}"
                    alt="Preview"
                    class="w-full rounded border"
                />

                {{-- Dominant Colors --}}
                @if(!empty($current->dominant_colors))
                    <div class="mt-3">
                        <span class="text-xs text-gray-500 font-semibold">Dominant Colors:</span>
                        <div class="flex gap-1 mt-1">
                            @foreach($current->dominant_colors as $hex)
                                <div
                                    class="w-6 h-6 rounded border border-gray-300"
                                    style="background-color: {{ $hex }}"
                                    title="{{ $hex }}"
                                ></div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <p class="text-xs text-gray-400 mt-2">ID: {{ $current->id }} &middot; Status: {{ $current->status }}</p>
            </div>

            {{-- RIGHT: Sort Form --}}
            <div>
                <form wire:submit.prevent="sort" class="space-y-3">

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="title" class="mt-1 w-full border border-gray-300 rounded p-2 text-sm" placeholder="Judul gambar..." />
                    </div>

                    {{-- Category --}}
                    <div>
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            @if(!$showAddCategory)
                                <button type="button" wire:click="$set('showAddCategory', true)" class="text-xs text-indigo-600 hover:text-indigo-850 font-medium">+ Add New</button>
                            @endif
                        </div>

                        @if($showAddCategory)
                            <div class="mt-1 flex gap-2">
                                <input type="text" wire:model="newCategoryName" class="w-full border border-gray-300 rounded p-2 text-sm" placeholder="Nama kategori baru..." />
                                <button type="button" wire:click="addCategory" class="px-3 py-1 bg-indigo-600 text-white rounded text-xs font-semibold hover:bg-indigo-700">Add</button>
                                <button type="button" wire:click="$set('showAddCategory', false)" class="px-3 py-1 border border-gray-300 text-gray-700 rounded text-xs hover:bg-gray-50">Cancel</button>
                            </div>
                        @else
                            <select wire:model="category_id" class="mt-1 w-full border border-gray-300 rounded p-2 text-sm">
                                <option value="">-- Pilih Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        @endif
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
                        <button type="button" wire:click="toggleFavorite" class="text-sm flex items-center gap-1 font-medium text-gray-700">
                            @if($is_favorite)
                                <span class="text-yellow-500 text-lg">★</span> <span class="text-indigo-650">Favorited</span>
                            @else
                                <span class="text-gray-400 text-lg">☆</span> <span class="text-gray-500">Not Favorite</span>
                            @endif
                        </button>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between pt-3 border-t">
                        <span class="text-sm text-gray-500 font-medium">{{ $remainingCount }} item tersisa</span>
                        <div class="flex gap-2">
                            <button type="button" wire:click="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini secara permanen?')" class="px-4 py-2 bg-red-650 text-white rounded text-sm hover:bg-red-700 transition">
                                Delete 🗑
                            </button>
                            <button type="button" wire:click="skip" class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-700 bg-white hover:bg-gray-50 transition">
                                Skip
                            </button>
                            <button type="submit" class="px-4 py-2 bg-indigo-650 text-white rounded text-sm font-medium hover:bg-indigo-700 transition">
                                Sort ✓
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-12 text-gray-500">
            <p class="text-2xl mb-2">📭</p>
            <p class="font-medium">Inbox kosong!</p>
            <p class="text-sm mt-1">Upload gambar dulu di halaman <a href="{{ route('upload.create') }}" class="text-indigo-600 underline">Upload</a>.</p>
        </div>
    @endif
</div>
