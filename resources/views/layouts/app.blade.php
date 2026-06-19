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
    </div>

    {{-- Main Content --}}
    <main class="max-w-5xl mx-auto px-4 pb-8">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
