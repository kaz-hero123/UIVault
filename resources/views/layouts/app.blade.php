<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIVault</title>
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <nav class="bg-white border-b border-gray-200 py-4 px-6 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-8">
            <a href="/" class="text-xl font-bold tracking-tight text-indigo-600">UIVault</a>
            <div class="flex items-center gap-4">
                <a href="/upload" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Upload</a>
                <a href="/inbox" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Inbox</a>
                <a href="/explorer" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Explorer</a>
            </div>
        </div>
    </nav>
    <main class="flex-1 container mx-auto px-4 py-8">
        @yield('content')
    </main>
    @livewireScripts
</body>
</html>
