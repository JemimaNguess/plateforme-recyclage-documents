@extends('layouts.admin')

@section('contenu')
    <h1 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Gestion des utilisateurs
    </h1>

    <form method="GET" class="mb-4">
        <input type="text" name="recherche" placeholder="Rechercher par nom ou email" value="{{ request('recherche') }}" class="border-gray-300 rounded w-full md:w-96">
        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded text-sm ml-2">Rechercher</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Rôle</th>
                    <th class="px-4 py-3">Statut</th>
                    <th class="px-4 py-3">Inscrit le</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($utilisateurs as $utilisateur)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $utilisateur->name }}</td>
                        <td class="px-4 py-3">{{ $utilisateur->email }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded {{ $utilisateur->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ $utilisateur->role }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded {{ $utilisateur->statut === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $utilisateur->statut }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $utilisateur->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($utilisateur->role !== 'admin')
                                <form method="POST" action="{{ route('admin.utilisateurs.toggle-statut', $utilisateur) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs bg-gray-800 hover:bg-gray-900 text-white px-3 py-1.5 rounded">
                                        {{ $utilisateur->statut === 'actif' ? 'Suspendre' : 'Réactiver' }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $utilisateurs->links() }}
    </div>
@endsection