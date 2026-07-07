<div class="flex-1 flex w-full h-full bg-surface">
    @if($mode === 'grid')
        @if($inboxItems->count() > 0)
            <div class="w-full flex flex-col h-full overflow-y-auto px-margin-desktop py-margin-desktop relative no-scrollbar">
                <div class="flex justify-between items-end mb-10 shrink-0">
                    <div>
                        <h1 class="font-display-lg text-display-lg text-on-surface mb-2 tracking-tight">Inbox Sorter</h1>
                        <p class="font-body-md text-body-md text-on-surface-variant">{{ $remainingCount }} inspirations waiting to be categorized.</p>
                    </div>
                </div>

                <!-- Masonry Grid for Inbox -->
                <div class="columns-1 sm:columns-2 lg:columns-3 2xl:columns-4 gap-6 w-full pb-12">
                    @foreach($inboxItems as $item)
                        <div wire:click="selectItem({{ $item->id }})" 
                             x-data="{ 
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
                             class="animate-cascade-fade cursor-pointer relative group rounded-[24px] overflow-hidden bg-surface-container-low mb-6 border border-white/40 shadow-sm shadow-black/5 hover:shadow-2xl hover:shadow-black/10 break-inside-avoid origin-center min-h-[150px]">
                            
                            <div x-show="!imgLoaded" class="absolute inset-0 bg-surface-variant animate-pulse flex items-center justify-center">
                                <span class="material-symbols-outlined text-outline-variant/30 text-4xl">image</span>
                            </div>
                            
                            <div class="overflow-hidden rounded-[24px]">
                                <img @load="imgLoaded = true" :class="imgLoaded ? 'opacity-100' : 'opacity-0'" class="w-full h-auto block object-cover group-hover:scale-105 transition-all duration-700 ease-out" src="{{ \Illuminate\Support\Facades\Storage::url($item->image_path) }}" alt="Inbox item"/>
                            </div>
                            
                            <!-- Glassmorphism overlay on hover -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6 rounded-[24px]">
                                <div class="w-full flex justify-center translate-y-4 group-hover:translate-y-0 transition-transform duration-500 ease-out">
                                    <div class="bg-white/20 backdrop-blur-md border border-white/30 text-white font-label-md text-label-md px-6 py-2.5 rounded-full flex items-center gap-2 shadow-lg">
                                        <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
                                        Sort Now
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4 pb-8">
                    {{ $inboxItems->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="flex-1 flex flex-col items-center justify-center py-20 text-center w-full h-full">
                <span class="material-symbols-outlined text-[64px] text-outline-variant mb-4 font-light">inbox</span>
                <h3 class="font-headline-lg-mobile text-headline-lg-mobile text-on-surface mb-2">Inbox Kosong!</h3>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-sm mb-6">Kamu belum memiliki gambar yang harus disortir.</p>
                <a href="{{ route('upload.create') }}" class="px-6 py-3 bg-primary text-on-primary rounded-lg font-title-md text-body-md font-medium hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm flex items-center gap-2 hover:scale-105 duration-200">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    Upload Gambar
                </a>
            </div>
        @endif
    @elseif($mode === 'sort' && $current)
        <!-- Left Panel (~60%): Preview Area -->
        <section class="flex-[6] bg-surface-container-low flex items-center justify-center p-margin-desktop relative overflow-hidden">
            <!-- Subtle background grid pattern for "digital paper" feel -->
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(var(--color-on-surface) 1px, transparent 1px); background-size: 24px 24px;"></div>
            
            <!-- Back Button Overlay -->
            <button wire:click="backToGrid" class="absolute top-8 left-8 z-20 w-12 h-12 rounded-full bg-surface-subtle/80 hover:bg-surface text-on-surface flex items-center justify-center border border-border-quiet shadow-sm hover:shadow-md transition-all hover:-translate-x-1 backdrop-blur-md" title="Back to Grid">
                <span class="material-symbols-outlined">arrow_back</span>
            </button>

            <!-- Mobile UI Preview Card -->
            <div x-data="{ imgLoaded: false }" class="relative w-full max-w-[420px] aspect-[9/19] rounded-[2.5rem] bg-surface border border-quiet shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden transition-transform duration-500 hover:scale-[1.01] hover:shadow-[0_12px_40px_rgba(0,0,0,0.06)] flex flex-col">
                <!-- Faux Device Top Bar -->
                <div class="h-12 w-full flex justify-center items-end pb-2 px-6 shrink-0 z-10 absolute top-0 left-0 bg-gradient-to-b from-black/10 to-transparent">
                    <div class="w-1/3 h-6 bg-black/80 rounded-full"></div>
                </div>
                
                <div x-show="!imgLoaded" class="absolute inset-0 bg-surface-variant animate-pulse flex items-center justify-center z-0">
                    <span class="material-symbols-outlined text-outline-variant/30 text-4xl">image</span>
                </div>
                
                <!-- The Content Image -->
                <img @load="imgLoaded = true" :class="imgLoaded ? 'opacity-100' : 'opacity-0'" class="w-full h-full object-cover transition-opacity duration-500 relative z-0" src="{{ \Illuminate\Support\Facades\Storage::url($current->image_path) }}" alt="Preview"/>
            </div>
        </section>

        <!-- Right Panel (~40%): Metadata Form -->
        <section class="flex-[4] bg-surface border-l border-quiet flex flex-col pt-margin-desktop px-margin-desktop pb-8 overflow-y-auto">
            <!-- Header Row -->
            <div class="flex justify-between items-center mb-10 shrink-0">
                <span class="font-mono-label text-mono-label text-on-surface-variant bg-surface-subtle px-3 py-1.5 rounded-full border border-border-quiet">{{ $remainingCount }} items remaining</span>
                
                <button type="button" wire:click="toggleFavorite" class="text-outline-variant hover:text-error transition-colors p-2 rounded-full hover:bg-error-container/50 group">
                    <span class="material-symbols-outlined text-[24px] {{ $is_favorite ? 'text-error' : '' }}" {!! $is_favorite ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>favorite</span>
                </button>
            </div>
            
            <form wire:submit.prevent="sort" class="flex flex-col gap-8 flex-1 h-full">
                <!-- Form Container -->
                <div class="flex flex-col gap-8 flex-1">
                    
                    <!-- Field: Title (Floating Label) -->
                    <div class="relative group">
                        <input wire:model="title" id="title" class="peer w-full bg-surface-subtle border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-surface rounded-xl px-4 pt-6 pb-2 font-body-md text-body-md text-on-surface outline-none transition-all placeholder-transparent shadow-sm hover:shadow-md" type="text" placeholder="Design Title"/>
                        <label for="title" class="absolute left-4 top-3.5 text-on-surface-variant transition-all peer-placeholder-shown:text-body-md peer-placeholder-shown:top-3.5 peer-focus:top-1.5 peer-focus:text-[10px] peer-focus:font-bold peer-focus:text-primary peer-focus:uppercase opacity-70 pointer-events-none peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-[10px] peer-[:not(:placeholder-shown)]:font-bold peer-[:not(:placeholder-shown)]:uppercase">Title</label>
                    </div>
                    
                    <!-- Field: Category -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant">Category</label>
                            @if(!$showAddCategory)
                                <button type="button" wire:click="$set('showAddCategory', true)" class="font-label-sm text-label-sm text-primary hover:text-primary-container">+ Add New</button>
                            @endif
                        </div>
                        
                        @if($showAddCategory)
                            <div class="flex gap-2">
                                <input type="text" wire:model="newCategoryName" class="w-full bg-surface-subtle border border-transparent focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-surface rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface outline-none transition-all placeholder:text-outline-variant shadow-sm" placeholder="New Category Name..." />
                                <button type="button" wire:click="addCategory" class="px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-medium hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-sm">Add</button>
                                <button type="button" wire:click="$set('showAddCategory', false)" class="px-4 py-2 bg-transparent border border-outline rounded-lg text-sm font-medium hover:bg-surface-subtle transition-colors">Cancel</button>
                            </div>
                        @else
                            <div class="relative">
                                <select wire:model="category_id" class="w-full bg-surface-subtle border border-transparent focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-surface rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface outline-none transition-all appearance-none cursor-pointer shadow-sm">
                                    <option value="">-- Choose Category --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Field: Tags -->
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Tags (Comma separated)</label>
                        <div class="flex flex-wrap gap-2 p-3 bg-surface-subtle rounded-lg border border-transparent focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20 focus-within:bg-surface transition-all min-h-[56px] items-center shadow-sm">
                            <input wire:model="tagsInput" list="existing-tags" class="bg-transparent border-none outline-none font-body-md text-body-md text-on-surface placeholder:text-outline-variant flex-1 min-w-[120px] px-1 py-1" placeholder="dashboard, minimal, login..." type="text"/>
                            <datalist id="existing-tags">
                                @foreach($existingTags as $tag)
                                    <option value="{{ $tag }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    
                    <!-- Field: Notes -->
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Notes</label>
                        <textarea wire:model="notes" class="w-full bg-surface-subtle border border-transparent focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-surface rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface outline-none transition-all placeholder:text-outline-variant resize-none h-32 shadow-sm" placeholder="Add observations or notes..."></textarea>
                    </div>
                    
                    <!-- Field: Source URL (Floating Label) -->
                    <div class="relative group">
                        <input wire:model="source_url" id="source_url" class="peer w-full bg-surface-subtle border border-transparent focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-surface rounded-xl pl-10 pr-4 pt-6 pb-2 font-body-md text-body-md text-on-surface outline-none transition-all placeholder-transparent shadow-sm hover:shadow-md" type="url" placeholder="https://..."/>
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline-variant text-[20px] pointer-events-none peer-focus:text-primary transition-colors">link</span>
                        <label for="source_url" class="absolute left-10 top-3.5 text-on-surface-variant transition-all peer-placeholder-shown:text-body-md peer-placeholder-shown:top-3.5 peer-focus:top-1.5 peer-focus:text-[10px] peer-focus:font-bold peer-focus:text-primary peer-focus:uppercase opacity-70 pointer-events-none peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-[10px] peer-[:not(:placeholder-shown)]:font-bold peer-[:not(:placeholder-shown)]:uppercase">Source URL</label>
                    </div>
                    
                    {{-- Dominant Colors Info if available --}}
                    @if(!empty($current->dominant_colors))
                        <div>
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Dominant Colors</label>
                            <div class="flex gap-2 mt-1">
                                @foreach($current->dominant_colors as $hex)
                                    <div class="w-8 h-8 rounded-full border border-border-quiet shadow-sm" style="background-color: {{ $hex }}" title="{{ $hex }}"></div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Action Area (Sticky-ish to bottom) -->
                <div class="mt-8 pt-6 border-t border-quiet shrink-0">
                    <div class="flex gap-4 items-center">
                        <!-- Hold-to-Delete Haptic Button -->
                        <button type="button" 
                                x-data="{ timer: null, progress: 0 }" 
                                @mousedown="timer = setInterval(() => { progress += 10; if (progress >= 100) { clearInterval(timer); @this.delete() } }, 50)" 
                                @mouseup="clearInterval(timer); progress = 0" 
                                @mouseleave="clearInterval(timer); progress = 0"
                                class="relative p-3 text-error border border-transparent hover:border-error hover:bg-error-container/30 rounded-lg transition-colors flex items-center justify-center overflow-hidden w-12 h-12 shrink-0 group select-none shadow-sm hover:shadow-md"
                                title="Hold to delete">
                            <!-- Progress fill -->
                            <div class="absolute bottom-0 left-0 w-full bg-error/20 transition-all duration-75 ease-linear pointer-events-none" :style="`height: ${progress}%`"></div>
                            <span class="material-symbols-outlined relative z-10 transition-transform group-active:scale-90">delete</span>
                        </button>
                        <button type="button" wire:click="skip" class="flex-[1] bg-transparent text-on-surface border border-outline hover:bg-surface-subtle hover:border-on-surface-variant rounded-lg py-3 font-title-md text-body-md font-medium transition-colors">
                            Skip
                        </button>
                        <button type="submit" class="flex-[2] bg-primary text-on-primary rounded-lg py-3 font-title-md text-body-md font-medium hover:bg-primary-container hover:text-on-primary-container transition-all hover:scale-[1.02] shadow-[0_4px_14px_rgba(0,0,0,0.1)] hover:shadow-none flex items-center justify-center gap-2">
                            <span>Sort</span>
                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                        </button>
                    </div>
                    <div class="text-center mt-4 pb-4">
                        <span class="font-mono-label text-mono-label text-on-surface-variant">
                            Or press <kbd class="font-sans px-1.5 py-0.5 rounded border border-outline-variant bg-surface mx-0.5 shadow-sm">Enter</kbd> to sort (if title is focused)
                        </span>
                    </div>
                </div>
            </form>
        </section>
    @endif
</div>
