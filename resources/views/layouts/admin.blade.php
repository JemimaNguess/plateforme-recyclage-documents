<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titre', 'Administration') — Plateforme Recyclage</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,600,700|inter:400,500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F4F4F4] text-[#4A4A4A]" x-data="{ mobileMenuOpen: false }">
<div class="min-h-screen flex">

    {{-- ================= OVERLAY MOBILE ================= --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false" 
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         x-cloak></div>

    {{-- ================= SIDEBAR (DESKTOP ET MOBILE) ================= --}}
    <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-[#2B2B2B] text-white flex flex-col shrink-0 transition-transform duration-300 ease-in-out">
        
        {{-- En-tête Sidebar --}}
        <div class="px-5 py-5 flex items-center justify-between border-b border-white/10">
            <div class="h-9 flex items-center font-bold text-lg tracking-wide" style="font-family:'Poppins',sans-serif;">
                Administration
            </div>
            {{-- Bouton fermer sur mobile --}}
            <button @click="mobileMenuOpen = false" class="lg:hidden text-white/70 hover:text-white p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-6 overflow-y-auto">
            {{-- Tableau de bord --}}
            <div>
                <a href="{{ route('admin.tableau-bord') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('admin.tableau-bord') ? 'bg-[#B3121A] text-white' : 'text-white/80 hover:bg-white/10' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Tableau de bord
                </a>
            </div>

            {{-- Gestion --}}
            <div>
                <p class="px-3 mb-2 text-[11px] font-semibold tracking-wider text-white/40 uppercase">Gestion</p>
                <div class="space-y-1">
                    <a href="{{ route('admin.utilisateurs') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.utilisateurs') ? 'bg-[#B3121A] text-white' : 'text-white/80 hover:bg-white/10' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-4a4 4 0 100-8 4 4 0 000 8zm7 4a4 4 0 00-3-3.87"/>
                        </svg>
                        Utilisateurs
                    </a>
                    <a href="{{ route('admin.documents') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.documents') ? 'bg-[#B3121A] text-white' : 'text-white/80 hover:bg-white/10' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Documents
                    </a>
                    <a href="{{ route('admin.signalements') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.signalements') ? 'bg-[#B3121A] text-white' : 'text-white/80 hover:bg-white/10' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18m0-15l6-1.5 6 1.5 6-1.5v10.5l-6 1.5-6-1.5-6 1.5"/>
                        </svg>
                        Signalements
                        @if(isset($signalementsEnAttente) && $signalementsEnAttente > 0)
                            <span class="ml-auto bg-white text-[#B3121A] text-xs font-bold px-2 py-0.5 rounded-full">{{ $signalementsEnAttente }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.categories') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                              {{ request()->routeIs('admin.categories') ? 'bg-[#B3121A] text-white' : 'text-white/80 hover:bg-white/10' }}">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                        </svg>
                        Catégories
                    </a>
                </div>
            </div>

            {{-- Paramètres --}}
            <div>
                <p class="px-3 mb-2 text-[11px] font-semibold tracking-wider text-white/40 uppercase">Paramètres</p>
                <div class="space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:bg-white/10 transition">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 5v1a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h5a2 2 0 012 2v1"/>
                            </svg>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </aside>

    {{-- ================= CONTENU PRINCIPAL ================= --}}
    <div class="flex-1 min-w-0 flex flex-col">

        {{-- Header réorganisé et équilibré --}}
        <header class="bg-white border-b border-gray-200 px-4 lg:px-8 py-3 flex items-center justify-between gap-4">
            
            {{-- Partie Gauche : Menu mobile + Titre discret sur Desktop --}}
            <div class="flex items-center gap-3">
                {{-- Bouton Toggle Mobile --}}
                <button @click="mobileMenuOpen = true" class="lg:hidden text-[#2B2B2B] hover:text-[#B3121A] p-1.5 rounded-lg hover:bg-gray-100 transition focus:outline-none" aria-label="Ouvrir le menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Indication visuelle Espace Admin (Desktop uniquement) --}}
                <div class="hidden lg:flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#B3121A]"></span>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Plateforme Administration</span>
                </div>
            </div>

            {{-- Partie Droite : Notifications & Profil Mieux Espacés --}}
            <div class="flex items-center gap-4 sm:gap-6">
                
                {{-- Bouton Notification avec Effet Hover --}}
                <button class="relative p-2 text-gray-500 hover:text-[#B3121A] hover:bg-gray-50 rounded-lg transition" title="Notifications">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(isset($notificationsCount) && $notificationsCount > 0)
                        <span class="absolute top-1.5 right-1.5 bg-[#B3121A] text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-white">
                            {{ $notificationsCount }}
                        </span>
                    @endif
                </button>

                {{-- Séparateur discret --}}
                <div class="h-6 w-px bg-gray-200"></div>

                {{-- Profil Administrateur --}}
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#E8A3A7]/30 border border-[#E8A3A7] flex items-center justify-center font-bold text-[#B3121A] text-sm shrink-0 shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="font-semibold text-[#2B2B2B] text-sm leading-tight truncate max-w-[140px]">
                            {{ auth()->user()->name ?? 'Administrateur' }}
                        </p>
                        <p class="text-[11px] text-gray-400 font-medium">Administrateur</p>
                    </div>
                </div>

            </div>
        </header>

        {{-- Messages flash --}}
        @if (session('succes'))
            <div class="max-w-6xl w-full mx-auto mt-4 px-4">
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">
                    {{ session('succes') }}
                </div>
            </div>
        @endif

        @if (session('erreur'))
            <div class="max-w-6xl w-full mx-auto mt-4 px-4">
                <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg text-sm">
                    {{ session('erreur') }}
                </div>
            </div>
        @endif

        {{-- Zone de contenu --}}
        <main class="flex-1 px-3 sm:px-6 lg:px-8 py-4 sm:py-6 overflow-x-hidden">
            @yield('contenu')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>