<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="font-display-lg text-display-lg text-on-surface mb-2">Categories</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Manage your inspiration categories</p>
        </div>
    </div>

    <div class="bg-surface-container-low rounded-2xl border border-border-quiet overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-quiet">
                <thead class="bg-surface-subtle">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider w-1/2">
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-4 text-left font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider w-1/4">
                            Items
                        </th>
                        <th scope="col" class="px-6 py-4 text-right font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider w-1/4">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-surface divide-y divide-quiet">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-surface-subtle/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($editingId === $cat->id)
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="text"
                                            wire:model="editingName"
                                            class="bg-surface border-b-2 border-primary px-3 py-1.5 font-body-md text-body-md text-on-surface outline-none focus:bg-surface-container-low transition-all w-full max-w-[200px]"
                                            placeholder="Category name"
                                        />
                                        <button
                                            type="button"
                                            wire:click="saveEdit"
                                            class="px-3 py-1.5 bg-primary hover:bg-primary-container hover:text-on-primary-container text-on-primary rounded-lg font-label-sm text-label-sm transition-colors"
                                        >
                                            Save
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="$set('editingId', null)"
                                            class="px-3 py-1.5 bg-transparent hover:bg-surface-subtle border border-outline rounded-lg text-on-surface-variant font-label-sm text-label-sm transition-colors"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                @else
                                    <span class="font-title-md text-title-md text-on-surface block">{{ $cat->name }}</span>
                                    <span class="font-mono-label text-[11px] text-on-surface-variant/70 block mt-0.5">slug: {{ $cat->slug }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-[11px] bg-secondary-container text-on-secondary-container border border-secondary/20">
                                    {{ $cat->ui_inspirations_count }} items
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                @if($editingId !== $cat->id)
                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="startEdit({{ $cat->id }})"
                                            class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-subtle rounded-lg transition-colors flex items-center justify-center group"
                                            title="Edit"
                                        >
                                            <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">edit</span>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="delete({{ $cat->id }})"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? {{ $cat->ui_inspirations_count }} item inspirasi akan diubah menjadi tanpa kategori.')"
                                            class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/30 rounded-lg transition-colors flex items-center justify-center group"
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
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-[48px] text-outline-variant mb-4 font-light">category</span>
                                    <h3 class="font-title-md text-title-md text-on-surface mb-1">No categories yet</h3>
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
