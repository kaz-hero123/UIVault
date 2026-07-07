<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UIVault — @yield('title', 'Home')</title>
    @livewireStyles
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
</head>
<body class="{{ $bodyClass ?? 'bg-background text-on-surface font-body-md antialiased min-h-screen flex overflow-x-hidden' }}">

    <x-sidebar />

    <div class="flex-1 flex flex-col ml-sidebar-width {{ $bodyClass ?? 'min-h-screen w-[calc(100%-260px)]' }}">
        @if(!isset($hideTopbar) || !$hideTopbar)
            <x-topbar />
        @endif

        <main class="flex-1 w-full {{ isset($noPadding) && $noPadding ? '' : 'px-margin-desktop py-margin-desktop pt-24' }}">
            {{-- Flash Messages --}}
            @if(!isset($noPadding) || !$noPadding)
                <div class="mb-6">
                    @if (session('success'))
                        <div class="mb-4 p-3 bg-secondary-container text-on-secondary-container rounded-lg border border-secondary text-sm shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">check_circle</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-3 bg-error-container text-on-error-container rounded-lg border border-error text-sm shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">error</span>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('upload_result'))
                        <div class="mb-4 p-4 bg-primary-container text-on-primary-container rounded-lg shadow-sm border border-primary-fixed-dim text-sm">
                            <div class="flex items-center gap-2 font-title-md text-title-md">
                                <span class="material-symbols-outlined">cloud_done</span> Upload Selesai
                            </div>
                            <p class="mt-1 font-body-md text-body-md opacity-90">
                                <strong>{{ session('upload_result.success_count') }}</strong> file berhasil diupload ke Inbox.
                            </p>
                            @if (count(session('upload_result.failed', [])) > 0)
                                <div class="mt-3 border-t border-primary-fixed-dim/30 pt-3">
                                    <span class="font-label-sm text-label-sm text-error uppercase tracking-wider block mb-1">Beberapa file gagal:</span>
                                    <ul class="list-disc list-inside space-y-1 text-xs opacity-80">
                                        @foreach (session('upload_result.failed') as $failedUpload)
                                            <li>
                                                <span class="font-medium">{{ $failedUpload['filename'] }}</span> — <span class="text-error">{{ $failedUpload['reason'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>
