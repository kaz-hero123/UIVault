<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="font-display-lg text-display-lg text-on-surface mb-2">Categories</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Manage your inspiration categories</p>
        </div>
    </div>

    <div class="bg-surface-container-low rounded-2xl border border-border-quiet overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-quiet/50">
                <thead class="bg-surface-subtle">
                    <tr>
                        <th scope="col" class="px-6 py-5 text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider w-1/2">
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-5 text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider w-1/4">
                            Items
                        </th>
                        <th scope="col" class="px-6 py-5 text-right font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider w-1/4">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-surface divide-y divide-quiet/50">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-surface-subtle/30 transition-all duration-200">
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($editingId === $cat->id)
                                    <div class="flex items-center gap-3 w-full">
                                        <input
                                            type="text"
                                            wire:model="editingName"
                                            class="bg-surface-container-low border border-outline-variant px-4 py-2 rounded-lg font-body-md text-body-md text-on-surface outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all w-full max-w-md shadow-sm"
                                            placeholder="Category name"
                                        />
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                wire:click="saveEdit"
                                                class="px-4 py-2 bg-primary hover:bg-primary/90 text-on-primary rounded-lg font-label-sm text-label-sm transition-all shadow-sm hover:shadow active:scale-95"
                                            >
                                                Save
                                            </button>
                                            <button
                                                type="button"
                                                wire:click="$set('editingId', null)"
                                                class="px-4 py-2 bg-surface hover:bg-surface-subtle border border-outline-variant hover:border-outline rounded-lg text-on-surface-variant font-label-sm text-label-sm transition-all shadow-sm active:scale-95"
                                            >
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <span class="font-title-md text-title-md text-on-surface block">{{ $cat->name }}</span>
                                    <span class="font-mono-label text-[11px] text-on-surface-variant/70 block mt-1">slug: {{ $cat->slug }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full font-label-sm text-[11px] bg-secondary-container/50 text-on-secondary-container border border-secondary/10 shadow-sm">
                                    {{ $cat->ui_inspirations_count }} items
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                @if($editingId !== $cat->id)
                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="startEdit({{ $cat->id }})"
                                            class="w-9 h-9 flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-primary/10 rounded-full transition-all duration-200 group"
                                            title="Edit"
                                        >
                                            <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">edit</span>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="delete({{ $cat->id }})"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? {{ $cat->ui_inspirations_count }} item inspirasi akan diubah menjadi tanpa kategori.')"
                                            class="w-9 h-9 flex items-center justify-center text-on-surface-variant hover:text-error hover:bg-error/10 rounded-full transition-all duration-200 group"
                                            title="Delete"
                                        >
                                            <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">delete</span>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-surface-subtle rounded-2xl flex items-center justify-center mb-5 shadow-inner">
                                        <span class="material-symbols-outlined text-[32px] text-on-surface-variant/70 font-light">category</span>
                                    </div>
                                    <h3 class="font-title-md text-title-md text-on-surface mb-2">No categories yet</h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant max-w-sm">Categories are created automatically when you sort items in the Inbox.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
