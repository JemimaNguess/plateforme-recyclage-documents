@extends('layouts.admin')

@section('titre', 'Gestion des utilisateurs')

@section('contenu')
    {{-- En-tête --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif;">
                Gestion des utilisateurs
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Consultez, recherchez et gérez les accès des membres de la plateforme.
            </p>
        </div>
        <span class="text-xs sm:text-sm text-gray-500">
            Total : <strong class="text-gray-800">{{ $utilisateurs->total() }}</strong> utilisateur(s)
        </span>
    </div>

    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('admin.utilisateurs') }}" class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" 
                       name="recherche" 
                       placeholder="Rechercher par nom ou adresse email..." 
                       value="{{ request('recherche') }}" 
                       class="w-full border-gray-200 rounded-lg text-sm focus:ring-[#B3121A] focus:border-[#B3121A] pl-4 pr-10 py-2">
            </div>
            
            <div class="flex gap-2">
                <button type="submit" class="bg-[#2B2B2B] hover:bg-black text-white px-5 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
                    Rechercher
                </button>
                
                @if(request()->filled('recherche'))
                    <a href="{{ route('admin.utilisateurs') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-lg text-sm transition flex items-center justify-center" title="Réinitialiser la recherche">
                        ✕
                    </a>
                @endif
            </div>
        </div>
    </form>

    {{-- Tableau des utilisateurs --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-[#2B2B2B] text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3.5">Nom</th>
                    <th class="px-4 py-3.5">Email</th>
                    <th class="px-4 py-3.5">Rôle</th>
                    <th class="px-4 py-3.5">Statut</th>
                    <th class="px-4 py-3.5">Inscrit le</th>
                    <th class="px-4 py-3.5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($utilisateurs as $utilisateur)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                            {{ $utilisateur->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                            {{ $utilisateur->email }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($utilisateur->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-[#B3121A]">
                                    Administrateur
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    Utilisateur
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($utilisateur->statut === 'actif')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600 mr-1.5"></span>
                                    Actif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 mr-1.5"></span>
                                    Suspendu
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500 whitespace-nowrap text-xs">
                            {{ $utilisateur->created_at?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            @if ($utilisateur->role !== 'admin')
                                <form method="POST" action="{{ route('admin.utilisateurs.toggle-statut', $utilisateur) }}" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir {{ $utilisateur->statut === 'actif' ? 'suspendre' : 'réactiver' }} ce compte ?');" 
                                      class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    @if ($utilisateur->statut === 'actif')
                                        <button type="submit" class="bg-[#B3121A] hover:bg-red-800 text-white text-xs px-3 py-1.5 rounded-lg font-medium transition">
                                            Suspendre
                                        </button>
                                    @else
                                        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white text-xs px-3 py-1.5 rounded-lg font-medium transition">
                                            Réactiver
                                        </button>
                                    @endif
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Protege</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            Aucun utilisateur ne correspond à votre recherche.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $utilisateurs->links() }}
    </div>
@endsection