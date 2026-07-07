<div class="flex-1 flex w-full">
    <!-- Left Panel (~60%): Preview Area -->
    <section class="flex-[6] bg-surface-container-low flex items-center justify-center p-margin-desktop relative overflow-hidden">
        <!-- Subtle background grid pattern for "digital paper" feel -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(var(--color-on-surface) 1px, transparent 1px); background-size: 24px 24px;"></div>
        
        <!-- Mobile UI Preview Card -->
        <div class="relative w-full max-w-[420px] aspect-[9/19] rounded-[2.5rem] bg-surface border border-quiet shadow-[0_8px_30px_rgba(0,0,0,0.04)] overflow-hidden transition-transform duration-500 hover:scale-[1.01] hover:shadow-[0_12px_40px_rgba(0,0,0,0.06)] flex flex-col">
            <!-- Faux Device Top Bar -->
            <div class="h-12 w-full flex justify-center items-end pb-2 px-6 shrink-0 z-10 absolute top-0 left-0 bg-gradient-to-b from-black/10 to-transparent">
                <div class="w-1/3 h-6 bg-black/80 rounded-full"></div>
            </div>
            
            <!-- The Content Image -->
            <img class="w-full h-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::url($inspiration->image_path) }}" alt="Preview"/>
        </div>
    </section>

    <!-- Right Panel (~40%): Metadata Form -->
    <section class="flex-[4] bg-surface border-l border-quiet flex flex-col pt-margin-desktop px-margin-desktop pb-8 overflow-y-auto">
        <!-- Header Row -->
        <div class="flex justify-between items-center mb-10 shrink-0">
            <div>
                <h1 class="font-display-sm text-display-sm text-on-surface">Edit Inspiration</h1>
                <p class="font-body-sm text-body-sm text-on-surface-variant">ID: {{ $inspiration->id }} &middot; Status: {{ $inspiration->status }}</p>
            </div>
            
            <button type="button" wire:click="$toggle('is_favorite')" class="text-outline-variant hover:text-error transition-colors p-2 rounded-full hover:bg-error-container/50 group">
                <span class="material-symbols-outlined text-[24px] {{ $is_favorite ? 'text-error' : '' }}" {!! $is_favorite ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>favorite</span>
            </button>
        </div>
        
        <form wire:submit.prevent="save" class="flex flex-col gap-8 flex-1 h-full">
            <!-- Form Container -->
            <div class="flex flex-col gap-8 flex-1">
                
                <!-- Field: Title -->
                <div>
                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Title</label>
                    <input wire:model="title" class="w-full bg-surface-subtle border-b-2 border-transparent focus:border-primary focus:bg-surface rounded-t-lg px-4 py-3 font-body-md text-body-md text-on-surface outline-none transition-all placeholder:text-outline-variant" type="text" placeholder="Design Title"/>
                </div>
                
                <!-- Field: Category -->
                <div>
                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Category</label>
                    <div class="relative">
                        <select wire:model="category_id" class="w-full bg-surface-subtle border-b-2 border-transparent focus:border-primary focus:bg-surface rounded-t-lg px-4 py-3 font-body-md text-body-md text-on-surface outline-none transition-all appearance-none cursor-pointer">
                            <option value="">-- Choose Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                </div>
                
                <!-- Field: Tags -->
                <div>
                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Tags (Comma separated)</label>
                    <div class="flex flex-wrap gap-2 p-3 bg-surface-subtle rounded-lg border border-transparent focus-within:border-primary/30 focus-within:bg-surface transition-all min-h-[56px] items-center">
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
                    <textarea wire:model="notes" class="w-full bg-surface-subtle border border-transparent focus:border-primary/30 focus:bg-surface rounded-lg px-4 py-3 font-body-md text-body-md text-on-surface outline-none transition-all placeholder:text-outline-variant resize-none h-32" placeholder="Add observations or notes..."></textarea>
                </div>
                
                <!-- Field: Source URL -->
                <div>
                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Source URL</label>
                    <div class="relative flex items-center bg-surface-subtle rounded-lg border border-transparent focus-within:border-primary/30 focus-within:bg-surface transition-all overflow-hidden">
                        <span class="material-symbols-outlined pl-4 text-outline-variant text-[20px]">link</span>
                        <input wire:model="source_url" class="w-full bg-transparent border-none px-3 py-3 font-body-md text-body-md text-on-surface outline-none placeholder:text-outline-variant" type="url" placeholder="https://..."/>
                    </div>
                </div>
                
                {{-- Dominant Colors Info if available --}}
                @if(!empty($inspiration->dominant_colors))
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Dominant Colors</label>
                        <div class="flex gap-2 mt-1">
                            @foreach($inspiration->dominant_colors as $hex)
                                <div class="w-8 h-8 rounded-full border border-border-quiet shadow-sm" style="background-color: {{ $hex }}" title="{{ $hex }}"></div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Action Area (Sticky-ish to bottom) -->
            <div class="mt-8 pt-6 border-t border-quiet shrink-0">
                <div class="flex gap-4 items-center">
                    <a href="{{ route('explorer') }}" class="flex-[1] bg-transparent text-center text-on-surface border border-outline hover:bg-surface-subtle hover:border-on-surface-variant rounded-lg py-3 font-title-md text-body-md font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="flex-[2] bg-primary text-on-primary rounded-lg py-3 font-title-md text-body-md font-medium hover:bg-primary-container hover:text-on-primary-container transition-colors shadow-[0_4px_14px_rgba(0,0,0,0.1)] hover:shadow-none flex items-center justify-center gap-2">
                        <span>Save Changes</span>
                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    </button>
                </div>
            </div>
        </form>
    </section>
</div>
