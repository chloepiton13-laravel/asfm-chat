<div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Header avec Logo de l'équipe -->
    <div class="flex items-center gap-6 mb-10 p-6 bg-white rounded-3xl border border-slate-200 shadow-sm">
        <div class="w-20 h-20 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center overflow-hidden">
            <img src="{{ asset('storage/' . $equipe->logo) }}" class="w-full h-full object-cover">
        </div>
        <div>
            <h1 class="text-2xl font-black text-slate-800 uppercase italic">{{ $equipe->nom }}</h1>
            <p class="text-[10px] font-black text-blue-600 uppercase tracking-[0.3em]">Historique Financier ASFM</p>
        </div>
    </div>

    <!-- Liste par Année -->
    <div class="space-y-12">
        @foreach($history as $year => $months)
            <div class="relative pl-8">
                <!-- Ligne verticale décorative -->
                <div class="absolute left-0 top-0 w-1 h-full bg-slate-100 rounded-full"></div>

                <h2 class="text-3xl font-black text-slate-200 uppercase mb-6 tracking-tighter">{{ $year }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($months as $payment)
                        <div class="relative bg-white p-5 rounded-2xl border border-slate-200 flex items-center justify-between hover:shadow-lg transition-all">
                            <!-- Indicateur de paiement -->
                            <div class="absolute -left-10 top-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-green-500 border-4 border-white ring-1 ring-slate-200"></div>

                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $payment->mois_concerne->translatedFormat('F') }}</p>
                                <p class="text-sm font-bold text-slate-700">Cotisation Mensuelle</p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-black text-blue-600">{{ number_format($payment->montant, 0, ',', '.') }} FC</p>
                                <p class="text-[9px] font-bold text-green-500 uppercase tracking-tighter italic">Payé le {{ $payment->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if($history->isEmpty())
            <div class="text-center py-20 bg-slate-50 rounded-[2rem] border-2 border-dashed border-slate-200">
                <span class="material-symbols-outlined text-5xl text-slate-200 mb-4">payments</span>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Aucun paiement enregistré pour le moment</p>
            </div>
        @endif
    </div>
</div>
