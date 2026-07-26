@extends('layouts.admin')

@section('titre', 'Tableau de bord')

@section('contenu')

    {{-- En-tête --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-[#2B2B2B]" style="font-family: 'Poppins', sans-serif;">
                Tableau de bord
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                Aperçu global de l'activité de la plateforme.
            </p>
        </div>
        <div class="flex items-center gap-2 bg-white border border-gray-100 shadow-sm rounded-lg px-3 py-2 text-xs sm:text-sm text-[#2B2B2B] self-start sm:self-auto">
            <svg class="w-4 h-4 text-[#B3121A]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    {{-- ================= CARTES STATISTIQUES ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- Documents --}}
        <a href="{{ route('admin.documents') }}" class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:border-gray-200 transition group">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Documents</p>
                </div>
                <span class="text-xs text-gray-400 group-hover:text-gray-600 transition">→</span>
            </div>
            <p class="text-3xl font-bold text-[#2B2B2B]">{{ number_format($totalDocuments, 0, ',', ' ') }}</p>
        </a>

        {{-- Utilisateurs --}}
        <a href="{{ route('admin.utilisateurs') }}" class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:border-gray-200 transition group">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m5-4a4 4 0 100-8 4 4 0 000 8zm7 4a4 4 0 00-3-3.87"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                </div>
                <span class="text-xs text-gray-400 group-hover:text-gray-600 transition">→</span>
            </div>
            <p class="text-3xl font-bold text-[#2B2B2B]">{{ number_format($totalUtilisateurs, 0, ',', ' ') }}</p>
        </a>

        {{-- Signalements --}}
        <a href="{{ route('admin.signalements', ['statut' => 'en_attente']) }}" class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-[#B3121A] hover:border-gray-200 transition group">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-[#B3121A]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18m0-15l6-1.5 6 1.5 6-1.5v10.5l-6 1.5-6-1.5-6 1.5"/>
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Signalements</p>
                </div>
                <span class="text-xs text-gray-400 group-hover:text-[#B3121A] transition">→</span>
            </div>
            <p class="text-3xl font-bold text-[#B3121A]">{{ $signalementsEnAttente }}</p>
        </a>

        {{-- Dépôts récents --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500">Dépôts (7 jours)</p>
            </div>
            <p class="text-3xl font-bold text-[#2B2B2B]">{{ $depotsRecents }}</p>
        </div>

    </div>

    {{-- ================= GRAPHIQUES OPTIONNELS ================= --}}
    @isset($evolutionLabels, $typesLabels)
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">
        <div class="xl:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-semibold text-[#2B2B2B] text-base mb-4">Évolution des dépôts</h2>
            <canvas id="graphiqueDocuments" height="110"></canvas>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <h2 class="font-semibold text-[#2B2B2B] text-base mb-4">Répartition par type</h2>
            <canvas id="graphiqueTypes" height="180"></canvas>
        </div>
    </div>
    @endisset

    {{-- ================= WIDGETS RECENT SAMPLES (OPTIONNELS) ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        @isset($derniersDocuments)
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-[#2B2B2B] text-base">Derniers documents déposés</h2>
                <a href="{{ route('admin.documents') }}" class="text-xs text-[#B3121A] hover:underline font-medium">Tout voir</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-400 border-b border-gray-100 text-xs uppercase tracking-wider">
                            <th class="pb-3 font-medium">Titre</th>
                            <th class="pb-3 font-medium">Filière / Matière</th>
                            <th class="pb-3 font-medium">Déposant</th>
                            <th class="pb-3 font-medium text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($derniersDocuments as $document)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 font-medium text-[#2B2B2B] max-w-xs truncate" title="{{ $document->titre }}">
                                    {{ $document->titre }}
                                </td>
                                <td class="py-3 text-gray-500 whitespace-nowrap">
                                    {{ $document->filiere?->nom ?? $document->matiere ?? '—' }}
                                </td>
                                <td class="py-3 text-gray-500 whitespace-nowrap">
                                    {{ $document->utilisateur?->name ?? $document->auteur ?? 'Utilisateur inconnu' }}
                                </td>
                                <td class="py-3 text-gray-400 text-right whitespace-nowrap text-xs">
                                    {{ $document->created_at?->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-400 text-sm">
                                    Aucun document récent.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endisset

        @isset($signalementsRecents)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-[#2B2B2B] text-base">Signalements récents</h2>
                <a href="{{ route('admin.signalements') }}" class="text-xs text-[#B3121A] hover:underline font-medium">Tout voir</a>
            </div>
            <div class="space-y-3">
                @forelse($signalementsRecents as $signalement)
                    <div class="flex items-start gap-3 pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#B3121A]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18m0-15l6-1.5 6 1.5 6-1.5v10.5l-6 1.5-6-1.5-6 1.5"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-[#2B2B2B] truncate" title="{{ $signalement->document?->titre ?? 'Document supprimé' }}">
                                {{ $signalement->document?->titre ?? 'Document supprimé' }}
                            </p>
                            <p class="text-xs text-gray-400">
                                Par <span class="text-gray-600">{{ $signalement->utilisateur?->name ?? 'Anonyme' }}</span> · {{ $signalement->created_at?->diffForHumans() }}
                            </p>
                        </div>
                        <span class="text-xs font-medium text-[#B3121A] bg-red-50 px-2.5 py-1 rounded-full shrink-0">
                            À traiter
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-6">
                        Aucun signalement en attente.
                    </p>
                @endforelse
            </div>
        </div>
        @endisset

    </div>

@endsection

@isset($evolutionLabels, $typesLabels)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
    new Chart(document.getElementById('graphiqueDocuments'), {
        type: 'line',
        data: {
            labels: @json($evolutionLabels),
            datasets: [{
                label: 'Documents déposés',
                data: @json($evolutionValeurs),
                borderColor: '#B3121A',
                backgroundColor: 'rgba(179,18,26,0.08)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#B3121A',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color: '#F4F4F4' } }, x: { grid: { display: false } } }
        }
    });

    new Chart(document.getElementById('graphiqueTypes'), {
        type: 'doughnut',
        data: {
            labels: @json($typesLabels),
            datasets: [{
                data: @json($typesValeurs),
                backgroundColor: ['#2B2B2B', '#B3121A', '#8A8A8A', '#E8A3A7', '#D9D9D9'],
                borderWidth: 0,
            }]
        },
        options: { 
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }, 
            cutout: '65%' 
        }
    });
</script>
@endpush
@endisset