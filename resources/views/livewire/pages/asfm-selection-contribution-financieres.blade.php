<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic">
                Suivi des <span class="text-blue-600">Contributions</span>
            </h1>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-1">10.000 FC / mois par sélection</p>
        </div>

        <div class="flex items-center gap-4 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm">
            <input type="month" wire:model.live="selectedMonth"
                class="border-none bg-transparent font-black text-sm text-blue-600 focus:ring-0">
            <div class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-black">
                Total : {{ number_format($totalDuMois, 0, ',', '.') }} FC
            </div>
        </div>
    </div>

    <!-- Table des paiements -->
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase">Sélection</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase">Montant Requis</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase text-center">Statut</th>
                    <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($equipes as $equipe)
                    @php $isPaid = isset($contributions[$equipe->id]) && $contributions[$equipe->id] === 'paye'; @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('storage/' . $equipe->logo) }}" class="w-full h-full object-cover">
                                </div>
                                <span class="font-bold text-slate-700 uppercase text-sm">{{ $equipe->nom }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 font-black text-slate-400 text-sm italic">10.000 FC</td>
                        <td class="px-8 py-5">
                            <div class="flex justify-center">
                                @if($isPaid)
                                    <span class="px-3 py-1 bg-green-100 text-green-600 text-[10px] font-black rounded-full uppercase border border-green-200">En ordre</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-600 text-[10px] font-black rounded-full uppercase border border-red-200">Impayé</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            @if(!$isPaid)
                                <button wire:click="enregistrerPaiement({{ $equipe->id }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-blue-200">
                                    Encaisser
                                </button>
                            @else
                                <span class="material-symbols-outlined text-green-500">check_circle</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
