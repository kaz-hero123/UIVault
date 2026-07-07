<!-- Floating Topbar (Generic) -->
<header class="bg-surface/70 backdrop-blur-xl fixed w-[calc(100%-260px-64px)] right-8 top-6 flex justify-end items-center h-[72px] px-6 z-30 border border-white/20 rounded-2xl shadow-lg shadow-black/5 transition-all">
    <div class="flex-1 flex items-center max-w-2xl">
        <div class="relative w-full group">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] transition-colors group-focus-within:text-primary">search</span>
            <input class="w-full bg-surface-subtle/50 hover:bg-surface-subtle border border-transparent rounded-xl pl-12 pr-4 py-3 font-body-md text-body-md focus:border-primary/50 focus:bg-surface focus:shadow-sm focus:ring-4 focus:ring-primary/10 transition-all outline-none" placeholder="Search..." type="text"/>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center pointer-events-none">
                <span class="font-mono-label text-[11px] bg-surface border border-border-quiet text-on-surface-variant px-2 py-1 rounded-md opacity-60">⌘K</span>
            </div>
        </div>
    </div>
    <div class="flex items-center space-x-3 ml-auto">
        <button class="text-on-surface-variant hover:text-primary transition-colors p-2 rounded-xl hover:bg-surface-subtle">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-border-quiet">
            <img src="https://ui-avatars.com/api/?name=User&background=random" alt="User Profile" class="w-full h-full object-cover"/>
        </div>
    </div>
</header>
