<nav style="background: var(--ink);" class="text-white border-b border-white/10 relative z-30" x-data="{ openUserMenu: false }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
        
        {{-- Brand / Logo --}}
        <a href="{{ route('documents.recherche') }}" class="font-display text-xl tracking-tight flex items-center gap-2 group">
            <span class="w-2.5 h-2.5 rounded-full" style="background-color: var(--blush);"></span>
            <span class="font-bold">Recyclage<span style="color: var(--blush);">.</span>Documents</span>
        </a>

        @auth
        <div class="flex items-center gap-3 sm:gap-4 text-sm">
            
            {{-- Liens principaux avec icônes --}}
            <a href="{{ route('documents.recherche') }}" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all text-white/80 hover:text-white hover:bg-white/10 {{ request()->routeIs('documents.recherche') ? 'bg-white/10 text-white font-medium' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Rechercher</span>
            </a>

            <a href="{{ route('documents.mes-documents') }}" 
               class="flex items-center gap-2 px-3 py-2 rounded-lg transition-all text-white/80 hover:text-white hover:bg-white/10 {{ request()->routeIs('documents.mes-documents') ? 'bg-white/10 text-white font-medium' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span>Mes documents</span>
            </a>

            {{-- Bouton d'action mis en valeur (CTA) --}}
            <a href="{{ route('documents.depot') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded-lg font-medium text-white transition-all shadow-sm hover:shadow hover:scale-[1.02] active:scale-[0.98]"
               style="background-color: var(--blush, #B3121A);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Déposer</span>
            </a>

            {{-- Séparateur --}}
            <div class="h-5 w-px bg-white/20 mx-1"></div>

            {{-- Dropdown Profil Utilisateur --}}
            <div class="relative" @click.outside="openUserMenu = false">
                <button @click="openUserMenu = !openUserMenu" 
                        class="flex items-center gap-2.5 p-1.5 pl-3 rounded-full bg-white/5 border border-white/10 hover:bg-white/10 transition text-left">
                    <span class="text-xs font-mono tracking-tight text-white/90 truncate max-w-[120px]">
                        {{ auth()->user()->name }}
                    </span>
                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs text-white uppercase"
                         style="background-color: rgba(255, 255, 255, 0.15);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <svg class="w-3.5 h-3.5 text-white/60 transition-transform duration-200 mr-1" 
                         :class="openUserMenu ? 'rotate-180' : ''" 
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Menu déroulant --}}
                <div x-show="openUserMenu" 
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                     class="absolute right-0 mt-2 w-48 rounded-xl bg-[#2B2B2B] border border-white/10 shadow-xl py-1 text-xs z-50 overflow-hidden"
                     x-cloak>
                    
                    <div class="px-4 py-2.5 border-b border-white/10">
                        <p class="text-white/50 text-[10px] uppercase font-semibold">Connecté en tant que</p>
                        <p class="text-white font-medium truncate mt-0.5">{{ auth()->user()->email ?? auth()->user()->name }}</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="border-t border-white/10">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center gap-2 px-4 py-2.5 text-red-400 hover:bg-red-500/10 transition text-left">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 5v1a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h5a2 2 0 012 2v1"/>
                            </svg>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @endauth
    </div>
</nav>