<nav class="bg-surface dark:bg-surface fixed left-0 top-0 h-screen w-sidebar-width border-r border-quiet dark:border-outline-variant flex flex-col py-margin-desktop space-y-stack-gap z-20">
    <!-- Header -->
    <div class="px-6 mb-8">
        <h1 class="font-headline-lg text-headline-lg font-semibold text-on-surface dark:text-on-surface tracking-tight">UIVault</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">UI/UX Inspiration</p>
    </div>

    <!-- Main Navigation -->
    <div class="flex-1 flex flex-col gap-1 w-full">
        <!-- Explorer -->
        <a class="flex items-center gap-3 py-2.5 {{ request()->is('explorer*') || request()->is('/') ? 'text-primary font-bold border-l-2 border-primary bg-surface-subtle pl-4' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-subtle transition-colors duration-200 pl-4' }}" href="{{ route('explorer') }}">
            <span class="material-symbols-outlined text-[20px]" {!! request()->is('explorer*') || request()->is('/') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>grid_view</span>
            <span class="font-body-md text-body-md">Explorer</span>
        </a>
        
        <!-- Inbox -->
        <a class="flex items-center gap-3 py-2.5 {{ request()->is('inbox*') ? 'text-primary font-bold border-l-2 border-primary bg-surface-subtle pl-4' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-subtle transition-colors duration-200 pl-4' }}" href="{{ route('inbox') }}">
            <span class="material-symbols-outlined text-[20px]" {!! request()->is('inbox*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>inbox</span>
            <span class="font-body-md text-body-md">Inbox</span>
        </a>

        <!-- Upload -->
        <a class="flex items-center gap-3 py-2.5 {{ request()->is('upload*') ? 'text-primary font-bold border-l-2 border-primary bg-surface-subtle pl-4' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-subtle transition-colors duration-200 pl-4' }}" href="{{ route('upload.create') }}">
            <span class="material-symbols-outlined text-[20px]" {!! request()->is('upload*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>add_circle</span>
            <span class="font-body-md text-body-md">Upload</span>
        </a>
        
        <!-- Categories -->
        <a class="flex items-center gap-3 py-2.5 {{ request()->is('categories*') ? 'text-primary font-bold border-l-2 border-primary bg-surface-subtle pl-4' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-subtle transition-colors duration-200 pl-4' }}" href="{{ route('categories') }}">
            <span class="material-symbols-outlined text-[20px]" {!! request()->is('categories*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>category</span>
            <span class="font-body-md text-body-md">Categories</span>
        </a>
    </div>

    <!-- CTA Area -->
    <div class="px-6 mt-8 mb-4">
        <a href="{{ route('upload.create') }}" class="w-full bg-primary text-on-primary font-title-md text-title-md py-3 rounded-lg flex items-center justify-center space-x-2 hover:bg-opacity-90 transition-all opacity-80 hover:opacity-100 shadow-sm">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add</span>
            <span>Upload</span>
        </a>
    </div>

    <!-- Footer Navigation -->
    <div class="flex flex-col space-y-2 mt-auto pt-6 border-t border-quiet mx-6">
        <a class="flex items-center space-x-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-subtle transition-colors duration-200 rounded-md px-2 -ml-2" href="#">
            <span class="material-symbols-outlined text-sm">settings</span>
            <span class="font-body-md text-body-md">Settings</span>
        </a>
        <a class="flex items-center space-x-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-subtle transition-colors duration-200 rounded-md px-2 -ml-2" href="#">
            <span class="material-symbols-outlined text-sm">help</span>
            <span class="font-body-md text-body-md">Support</span>
        </a>
    </div>
</nav>
