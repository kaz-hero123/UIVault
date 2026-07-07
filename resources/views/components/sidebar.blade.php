<nav class="bg-surface/80 backdrop-blur-2xl dark:bg-surface/80 fixed left-0 top-0 h-screen w-sidebar-width border-r border-white/20 dark:border-outline-variant flex flex-col py-margin-desktop space-y-stack-gap z-20 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transition-all">
    <!-- Header -->
    <div class="px-6 mb-8">
        <h1 class="font-headline-lg text-headline-lg font-semibold text-on-surface dark:text-on-surface tracking-tight">UIVault</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">UI/UX Inspiration</p>
    </div>

    <!-- Main Navigation -->
    <div class="flex-1 flex flex-col gap-2 w-full">
        <!-- Explorer -->
        <a class="relative flex items-center gap-3 py-3 px-4 mx-4 rounded-xl transition-all duration-300 group {{ request()->is('explorer*') || request()->is('/') ? 'text-primary bg-primary/10 font-medium' : 'text-on-surface-variant hover:bg-surface-subtle hover:text-on-surface' }}" href="{{ route('explorer') }}" wire:navigate>
            @if(request()->is('explorer*') || request()->is('/'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-primary rounded-r-full shadow-[0_0_8px_rgba(0,0,0,0.1)]"></div>
            @endif
            <span class="material-symbols-outlined text-[22px] transition-transform duration-300 group-hover:scale-110" {!! request()->is('explorer*') || request()->is('/') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>grid_view</span>
            <span class="font-body-md text-body-md tracking-wide">Explorer</span>
        </a>
        
        <!-- Inbox -->
        <a class="relative flex items-center gap-3 py-3 px-4 mx-4 rounded-xl transition-all duration-300 group {{ request()->is('inbox*') ? 'text-primary bg-primary/10 font-medium' : 'text-on-surface-variant hover:bg-surface-subtle hover:text-on-surface' }}" href="{{ route('inbox') }}" wire:navigate>
            @if(request()->is('inbox*'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-primary rounded-r-full shadow-[0_0_8px_rgba(0,0,0,0.1)]"></div>
            @endif
            <span class="material-symbols-outlined text-[22px] transition-transform duration-300 group-hover:scale-110" {!! request()->is('inbox*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>inbox</span>
            <span class="font-body-md text-body-md tracking-wide">Inbox</span>
        </a>

        <!-- Upload -->
        <a class="relative flex items-center gap-3 py-3 px-4 mx-4 rounded-xl transition-all duration-300 group {{ request()->is('upload*') ? 'text-primary bg-primary/10 font-medium' : 'text-on-surface-variant hover:bg-surface-subtle hover:text-on-surface' }}" href="{{ route('upload.create') }}" wire:navigate>
            @if(request()->is('upload*'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-primary rounded-r-full shadow-[0_0_8px_rgba(0,0,0,0.1)]"></div>
            @endif
            <span class="material-symbols-outlined text-[22px] transition-transform duration-300 group-hover:scale-110" {!! request()->is('upload*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>add_circle</span>
            <span class="font-body-md text-body-md tracking-wide">Upload</span>
        </a>
        
        <!-- Categories -->
        <a class="relative flex items-center gap-3 py-3 px-4 mx-4 rounded-xl transition-all duration-300 group {{ request()->is('categories*') ? 'text-primary bg-primary/10 font-medium' : 'text-on-surface-variant hover:bg-surface-subtle hover:text-on-surface' }}" href="{{ route('categories') }}" wire:navigate>
            @if(request()->is('categories*'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-primary rounded-r-full shadow-[0_0_8px_rgba(0,0,0,0.1)]"></div>
            @endif
            <span class="material-symbols-outlined text-[22px] transition-transform duration-300 group-hover:scale-110" {!! request()->is('categories*') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>category</span>
            <span class="font-body-md text-body-md tracking-wide">Categories</span>
        </a>
    </div>

    <!-- CTA Area -->
    <div class="px-6 mt-8 mb-4">
        <a href="{{ route('upload.create') }}" wire:navigate class="w-full bg-primary text-on-primary font-title-md text-title-md py-3 rounded-lg flex items-center justify-center space-x-2 hover:bg-opacity-90 transition-all opacity-80 hover:opacity-100 shadow-sm hover:scale-[1.02]">
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
