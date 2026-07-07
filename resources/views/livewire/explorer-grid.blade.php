<div class="w-full" x-data="{ previewOpen: false, previewImage: '', previewTitle: '' }" @keydown.escape.window="previewOpen = false">
    <!-- Floating Topbar for Explorer -->
    <header class="bg-surface/70 backdrop-blur-xl fixed w-[calc(100%-260px-64px)] right-8 top-6 flex justify-end items-center h-[72px] px-6 z-30 border border-white/20 rounded-2xl shadow-lg shadow-black/5 transition-all">
        <div class="flex-1 flex items-center max-w-2xl">
            <div class="relative w-full group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] transition-colors group-focus-within:text-primary">search</span>
                <input wire:model.live.debounce.300ms="search" class="w-full bg-surface-subtle/50 hover:bg-surface-subtle border border-transparent rounded-xl pl-12 pr-4 py-3 font-body-md text-body-md focus:border-primary/50 focus:bg-surface focus:shadow-sm focus:ring-4 focus:ring-primary/10 transition-all outline-none" placeholder="Search inspirations..." type="text"/>
            </div>
            
            <!-- Loading Indicator -->
            <div wire:loading class="ml-4 flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
        
        <div class="flex items-center space-x-3 ml-auto">
            <div class="flex items-center space-x-2">
                <div class="relative group">
                    <select wire:model.live="category_id" class="appearance-none bg-surface-subtle/50 flex items-center space-x-1 px-4 py-2.5 rounded-xl hover:bg-surface-subtle text-on-surface-variant transition-colors font-label-sm text-label-sm font-medium outline-none cursor-pointer pr-9 border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/10 focus:bg-surface">
                        <option value="">Category (All)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined text-[18px] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant group-hover:text-on-surface transition-colors">expand_more</span>
                </div>
                
                <div class="relative group">
                    <select wire:model.live="tag_id" class="appearance-none bg-surface-subtle/50 flex items-center space-x-1 px-4 py-2.5 rounded-xl hover:bg-surface-subtle text-on-surface-variant transition-colors font-label-sm text-label-sm font-medium outline-none cursor-pointer pr-9 border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/10 focus:bg-surface">
                        <option value="">Tag (All)</option>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined text-[18px] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant group-hover:text-on-surface transition-colors">expand_more</span>
                </div>
            </div>
            <div class="h-8 w-px bg-border-quiet mx-1"></div>
            <button class="text-on-surface-variant hover:text-primary transition-colors p-2 rounded-xl hover:bg-surface-subtle">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <button class="text-on-surface-variant hover:text-primary transition-colors p-2 rounded-xl hover:bg-surface-subtle">
                <span class="material-symbols-outlined">account_circle</span>
            </button>
        </div>
    </header>

    <!-- Spacer for fixed topbar -->
    <div class="h-[104px]"></div>

    <!-- View Controls (Minimal Chrome) -->
    <div class="flex justify-between items-center mb-10 mt-6 px-8">
        <h2 class="font-display-lg text-display-lg text-on-surface">Gallery</h2>
        <div class="flex items-center space-x-4 border-b border-border-quiet pb-2">
            <label class="flex items-center space-x-2 cursor-pointer group">
                <input type="checkbox" wire:model.live="favoritesOnly" class="rounded border-outline-variant text-primary focus:ring-primary w-4 h-4">
                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider group-hover:text-primary transition-colors">Favorites Only</span>
            </label>
        </div>
    </div>

    <!-- Masonry Grid -->
    @if($inspirations->count() > 0)
        <div wire:loading.class="opacity-50" class="columns-1 sm:columns-2 lg:columns-3 2xl:columns-4 gap-6 px-8 w-full pb-12 transition-opacity duration-300">
            @foreach($inspirations as $item)
                <div x-data="{ 
                        rotateX: 0, 
                        rotateY: 0, 
                        imgLoaded: false,
                        handleMove(e) { 
                            const r = this.$el.getBoundingClientRect(); 
                            const cx = r.width / 2; 
                            const cy = r.height / 2; 
                            this.rotateX = ((e.clientY - r.top - cy) / cy) * -8; 
                            this.rotateY = ((e.clientX - r.left - cx) / cx) * 8; 
                        },
                        handleLeave() { 
                            this.rotateX = 0; 
                            this.rotateY = 0; 
                        } 
                     }" 
                     @mousemove="handleMove" 
                     @mouseleave="handleLeave"
                     :style="`animation-delay: {{ $loop->index * 60 }}ms; transform: perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg); transition: transform 0.1s ease-out;`"
                     class="animate-cascade-fade relative group rounded-[24px] overflow-hidden bg-surface-container-low mb-6 border border-white/40 shadow-sm shadow-black/5 hover:shadow-2xl hover:shadow-black/10 break-inside-avoid origin-center">
                    
                    {{-- Edit/Delete Actions overlay at top left --}}
                    <div class="absolute top-4 left-4 z-20 flex gap-2 opacity-0 -translate-y-2 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                        <a href="{{ route('inspirations.edit', $item->id) }}" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur-md text-on-surface hover:bg-primary hover:text-on-primary transition-colors flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <button type="button" wire:click="deleteInspiration({{ $item->id }})" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini secara permanen?')" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur-md text-on-surface hover:bg-error hover:text-on-error transition-colors flex items-center justify-center shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>

                    {{-- Favorite Button overlay at top right --}}
                    <button wire:click="toggleFavorite({{ $item->id }})" class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full backdrop-blur-md transition-all duration-300 flex items-center justify-center shadow-sm {{ $item->is_favorite ? 'bg-white/90 text-error opacity-100 animate-heart-burst' : 'bg-black/20 text-white hover:bg-white/90 hover:text-error opacity-0 group-hover:opacity-100 -translate-y-2 group-hover:translate-y-0' }}">
                        <span class="material-symbols-outlined text-[20px]" {!! $item->is_favorite ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>favorite</span>
                    </button>

                    <div class="overflow-hidden rounded-[24px] cursor-pointer relative min-h-[150px]" @click="previewImage = '{{ $item->image_url }}'; previewTitle = '{{ addslashes($item->title ?? 'Untitled') }}'; previewOpen = true">
                        <!-- Skeleton Loading -->
                        <div x-show="!imgLoaded" class="absolute inset-0 bg-surface-variant animate-pulse flex items-center justify-center">
                            <span class="material-symbols-outlined text-outline-variant/30 text-4xl">image</span>
                        </div>
                        <img @load="imgLoaded = true" :class="imgLoaded ? 'opacity-100' : 'opacity-0'" class="w-full h-auto block object-cover transition-all duration-700 ease-out group-hover:scale-105" src="{{ $item->image_url }}" alt="{{ $item->title ?? 'Untitled' }}"/>
                    </div>
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-6 pointer-events-none rounded-[24px]">
                        <div class="flex justify-between items-end pointer-events-auto opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 delay-75">
                            <div class="space-y-1.5 w-full">
                                <div class="flex justify-between items-center">
                                    <span class="text-white/80 font-label-md text-label-md uppercase tracking-widest">{{ $item->category ?: 'Uncategorized' }}</span>
                                    @if($item->source_url)
                                        <a href="{{ $item->source_url }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/30 flex items-center justify-center text-white transition-colors backdrop-blur-sm" title="Source">
                                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                        </a>
                                    @endif
                                </div>
                                <h3 class="text-white font-display-sm text-display-sm truncate drop-shadow-md">{{ $item->title ?? 'Untitled' }}</h3>
                                
                                <div class="flex space-x-1.5 mt-3 pt-2 border-t border-white/10">
                                    @if(is_array($item->dominant_colors))
                                        @foreach(array_slice($item->dominant_colors, 0, 4) as $hex)
                                            <div class="w-4 h-4 rounded-full border border-white/20 shadow-sm" style="background-color: {{ $hex }}"></div>
                                        @endforeach
                                    @endif
                                </div>

                                @if(is_array($item->tags) && count($item->tags) > 0)
                                    <div class="flex flex-wrap gap-1.5 mt-3">
                                        @foreach($item->tags as $tag)
                                            <span class="font-mono-label text-[11px] bg-white/10 backdrop-blur-md border border-white/10 text-white px-2.5 py-1 rounded-md">#{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $inspirations->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <span class="material-symbols-outlined text-[64px] text-outline-variant mb-4 font-light">search_off</span>
            <h3 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface mb-2">Tidak ada hasil</h3>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-sm">Coba ubah kata kunci pencarian atau filter kategori/tag untuk menemukan apa yang Anda cari.</p>
        </div>
    @endif

    <!-- Alpine.js Lightbox Modal -->
    <div x-show="previewOpen" 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-12"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 backdrop-blur-none"
         x-transition:enter-end="opacity-100 backdrop-blur-xl"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 backdrop-blur-xl"
         x-transition:leave-end="opacity-0 backdrop-blur-none">
         
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60" @click="previewOpen = false"></div>
        
        <!-- Modal Content -->
        <div class="relative w-full max-w-5xl max-h-full flex flex-col items-center justify-center"
             x-transition:enter="transition ease-out duration-300 delay-75"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            
            <button @click="previewOpen = false" class="absolute -top-12 right-0 w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors backdrop-blur-md">
                <span class="material-symbols-outlined">close</span>
            </button>
            
            <img :src="previewImage" :alt="previewTitle" class="max-w-full max-h-[85vh] object-contain rounded-[24px] shadow-2xl shadow-black/50" />
            
            <div class="mt-6 text-center">
                <h2 x-text="previewTitle" class="text-white font-display-sm text-display-sm drop-shadow-md"></h2>
            </div>
        </div>
    </div>
</div>
