<div class="bg-white p-6 rounded shadow border">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Category Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Inspirations Count
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $cat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($editingId === $cat->id)
                                <div class="flex items-center gap-2">
                                    <input
                                        type="text"
                                        wire:model="editingName"
                                        class="border border-gray-300 rounded p-1.5 text-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                        placeholder="Category name"
                                    />
                                    <button
                                        type="button"
                                        wire:click="saveEdit"
                                        class="px-3 py-1.5 bg-indigo-650 hover:bg-indigo-700 text-white rounded text-xs font-medium transition"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="$set('editingId', null)"
                                        class="px-3 py-1.5 border border-gray-300 hover:bg-gray-50 text-gray-700 rounded text-xs font-medium transition"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            @else
                                <span class="font-medium text-gray-800">{{ $cat->name }}</span>
                                <span class="text-xs text-gray-400 block mt-0.5">Slug: {{ $cat->slug }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $cat->ui_inspirations_count }} item
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($editingId !== $cat->id)
                                <div class="flex justify-end gap-3">
                                    <button
                                        type="button"
                                        wire:click="startEdit({{ $cat->id }})"
                                        class="text-indigo-600 hover:text-indigo-900"
                                    >
                                        Rename ✏️
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="delete({{ $cat->id }})"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? {{ $cat->ui_inspirations_count }} item inspirasi akan diubah menjadi tanpa kategori.')"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Delete 🗑
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                            Belum ada kategori yang dibuat. Kategori dibuat otomatis saat menyortir item di Inbox.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
