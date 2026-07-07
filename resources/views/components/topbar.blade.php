<!-- Floating Topbar (Premium & Interactive) -->
<header x-data="{ searchFocused: false }" class="bg-surface/80 backdrop-blur-xl fixed w-[calc(100%-260px-64px)] right-8 top-6 flex justify-end items-center h-[72px] px-6 z-30 border border-white/20 rounded-2xl shadow-lg shadow-black/5 transition-all duration-500" :class="{ 'w-[calc(100%-260px-32px)] right-4 shadow-2xl': searchFocused }">
    
    <!-- Dim Backdrop when searching -->
    <div x-show="searchFocused" x-transition.opacity.duration.300ms class="fixed top-0 right-0 w-[200vw] h-[200vh] bg-surface/30 backdrop-blur-[2px] z-[-1]" @click="searchFocused = false" style="display: none; transform: translate(50%, -50%);"></div>

    <div class="flex-1 flex items-center max-w-2xl relative">
        <div class="relative w-full group">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] transition-colors duration-300 group-focus-within:text-primary">search</span>
            <input @focus="searchFocused = true" @blur="searchFocused = false" class="w-full bg-surface-subtle/50 hover:bg-surface-subtle border border-transparent rounded-xl pl-12 pr-4 py-3 font-body-md text-body-md focus:border-primary/50 focus:bg-surface focus:shadow-sm focus:ring-4 focus:ring-primary/10 transition-all outline-none" placeholder="Search inspirations..." type="text"/>
            <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center pointer-events-none transition-opacity duration-300" :class="{ 'opacity-0': searchFocused }">
                <span class="font-mono-label text-[11px] bg-surface border border-border-quiet text-on-surface-variant px-2 py-1 rounded-md opacity-60 shadow-sm">⌘K</span>
            </div>
        </div>
    </div>
    <div class="flex items-center space-x-4 ml-auto">
        <button class="text-on-surface-variant hover:text-primary transition-all p-2 rounded-xl hover:bg-surface-subtle relative group focus:outline-none">
            <span class="material-symbols-outlined transition-transform duration-300 group-hover:rotate-12 group-hover:scale-110">notifications</span>
            <span class="absolute top-2.5 right-2.5 w-1.5 h-1.5 bg-error rounded-full animate-ping"></span>
            <span class="absolute top-2.5 right-2.5 w-1.5 h-1.5 bg-error rounded-full"></span>
        </button>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false" class="w-10 h-10 rounded-full overflow-hidden border-2 border-transparent hover:border-primary transition-all ring-2 ring-transparent hover:ring-primary/20 outline-none focus:border-primary shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95 duration-300">
                <img src="https://ui-avatars.com/api/?name=User&background=random" alt="User Profile" class="w-full h-full object-cover"/>
            </button>

            <!-- Interactive Profile Dropdown -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90 translate-y-[-10px]"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-90 translate-y-[-10px]"
                 class="absolute right-0 mt-4 w-64 bg-surface/90 backdrop-blur-2xl rounded-2xl border border-white/20 shadow-2xl overflow-hidden flex flex-col py-2 z-50 origin-top-right"
                 style="display: none;">
                
                <div class="px-5 py-4 border-b border-border-quiet/40 bg-surface-subtle/50 backdrop-blur-sm">
                    <p class="text-body-lg font-semibold text-on-surface mb-0.5">Admin User</p>
                    <p class="text-label-sm text-on-surface-variant opacity-80">admin@uivault.com</p>
                </div>
                
                <div class="p-2 flex flex-col gap-1">
                    <a href="#" class="px-3 py-2.5 rounded-xl text-body-md text-on-surface-variant hover:bg-surface-subtle hover:text-primary transition-colors flex items-center gap-3 group">
                        <span class="material-symbols-outlined text-[18px] transition-transform group-hover:scale-110">account_circle</span> My Profile
                    </a>
                    <a href="#" class="px-3 py-2.5 rounded-xl text-body-md text-on-surface-variant hover:bg-surface-subtle hover:text-primary transition-colors flex items-center gap-3 group">
                        <span class="material-symbols-outlined text-[18px] transition-transform group-hover:scale-110">settings</span> Settings
                    </a>
                </div>
                <div class="border-t border-border-quiet/40 my-1"></div>
                <div class="p-2">
                    <a href="#" class="px-3 py-2.5 rounded-xl text-body-md text-error hover:bg-error-container hover:text-on-error-container transition-colors flex items-center gap-3 group">
                        <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">logout</span> Sign out
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
