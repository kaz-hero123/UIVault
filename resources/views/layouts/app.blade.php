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
<body class="{{ $bodyClass ?? 'bg-background text-on-surface font-body-md antialiased min-h-screen flex overflow-x-hidden relative' }}">

    <!-- Ambient Background Glow (Premium Effect) -->
    <div class="fixed inset-0 pointer-events-none z-[-1] overflow-hidden">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-primary/5 blur-[120px]"></div>
        <div class="absolute top-[60%] -right-[10%] w-[40%] h-[60%] rounded-full bg-secondary-container/30 blur-[120px]"></div>
    </div>

    <!-- Cinematic Noise Overlay -->
    <div class="fixed inset-0 pointer-events-none z-[100] opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.8%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');"></div>

    <x-sidebar />

    <div class="flex-1 flex flex-col ml-sidebar-width {{ $bodyClass ?? 'min-h-screen w-[calc(100%-260px)]' }}">
        @if(!isset($hideTopbar) || !$hideTopbar)
            <x-topbar />
        @endif

        <main class="flex-1 w-full {{ isset($noPadding) && $noPadding ? '' : 'px-margin-desktop py-margin-desktop pt-24' }}">
            {{-- Flash Messages (Floating Toasts) --}}
            <div class="fixed top-8 right-8 z-[110] flex flex-col gap-3 pointer-events-none min-w-[320px] max-w-[400px]">
                @if (session('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition.duration.500ms class="p-4 bg-secondary-container/90 backdrop-blur-xl text-on-secondary-container rounded-2xl border border-white/20 shadow-2xl pointer-events-auto flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 text-secondary">check_circle</span>
                        <div class="flex-1 font-body-md text-body-md mt-0.5">{{ session('success') }}</div>
                        <button @click="show = false" class="opacity-50 hover:opacity-100 transition-opacity"><span class="material-symbols-outlined text-[20px]">close</span></button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show" x-transition.duration.500ms class="p-4 bg-error-container/90 backdrop-blur-xl text-on-error-container rounded-2xl border border-error/20 shadow-2xl pointer-events-auto flex items-start gap-3">
                        <span class="material-symbols-outlined mt-0.5 text-error">error</span>
                        <div class="flex-1 font-body-md text-body-md mt-0.5">{{ session('error') }}</div>
                        <button @click="show = false" class="opacity-50 hover:opacity-100 transition-opacity"><span class="material-symbols-outlined text-[20px]">close</span></button>
                    </div>
                @endif

                @if (session('upload_result'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show" x-transition.duration.500ms class="p-5 bg-surface/90 backdrop-blur-xl text-on-surface rounded-2xl shadow-2xl border border-white/20 pointer-events-auto">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2 font-title-md text-title-md text-primary">
                                <span class="material-symbols-outlined">cloud_done</span> Upload Selesai
                            </div>
                            <button @click="show = false" class="opacity-50 hover:opacity-100 transition-opacity"><span class="material-symbols-outlined text-[20px]">close</span></button>
                        </div>
                        <p class="font-body-md text-body-md opacity-90 mb-3">
                            <strong>{{ session('upload_result.success_count') }}</strong> file berhasil diupload ke Inbox.
                        </p>
                        @if (count(session('upload_result.failed', [])) > 0)
                            <div class="border-t border-outline-variant/30 pt-3">
                                <span class="font-label-sm text-label-sm text-error uppercase tracking-wider block mb-1">Beberapa file gagal:</span>
                                <ul class="list-disc list-inside space-y-1 text-xs opacity-80 max-h-32 overflow-y-auto no-scrollbar">
                                    @foreach (session('upload_result.failed') as $failedUpload)
                                        <li>
                                            <span class="font-medium truncate inline-block max-w-[120px] align-bottom">{{ $failedUpload['filename'] }}</span> — <span class="text-error">{{ $failedUpload['reason'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>
