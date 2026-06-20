<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIVault — @yield('title', 'Home')</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Simple Nav --}}
    <nav class="bg-white shadow mb-6">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center gap-6">
            <a href="/" class="font-bold text-lg text-indigo-600">UIVault</a>
            <a href="{{ route('upload.create') }}" class="text-sm {{ request()->is('upload') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-indigo-600' }}">Upload</a>
            <a href="{{ route('inbox') }}" class="text-sm {{ request()->is('inbox') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-indigo-600' }}">Inbox</a>
            <a href="{{ route('explorer') }}" class="text-sm {{ request()->is('explorer') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-indigo-600' }}">Explorer</a>
            <a href="{{ route('categories') }}" class="text-sm {{ request()->is('categories') ? 'text-indigo-600 font-semibold' : 'text-gray-600 hover:text-indigo-600' }}">Categories</a>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="max-w-5xl mx-auto px-4">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-300 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-300 text-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if (session('upload_result'))
            <div class="mb-4 p-4 bg-indigo-50 border border-indigo-200 rounded-lg text-sm text-indigo-900 shadow-sm">
                <div class="flex items-center gap-2 font-semibold text-indigo-800">
                    ✨ Upload Selesai
                </div>
                <p class="mt-1">
                    <strong>{{ session('upload_result.success_count') }}</strong> file berhasil diupload ke Inbox.
                </p>
                @if (count(session('upload_result.failed', [])) > 0)
                    <div class="mt-3 border-t border-indigo-100 pt-2">
                        <span class="font-semibold text-xs text-red-600 uppercase tracking-wider">Beberapa file gagal:</span>
                        <ul class="list-disc list-inside mt-1 space-y-1 text-xs text-gray-600">
                            @foreach (session('upload_result.failed') as $failedUpload)
                                <li>
                                    <span class="font-medium text-gray-800">{{ $failedUpload['filename'] }}</span> — <span class="text-red-500">{{ $failedUpload['reason'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="max-w-5xl mx-auto px-4 pb-8">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
