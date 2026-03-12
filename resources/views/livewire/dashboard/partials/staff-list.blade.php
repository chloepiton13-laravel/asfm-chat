<!-- SECTION 05.1 : STAFF LIST -->
<div class="space-y-6">
    @foreach($membres as $membre)
        <div class="flex items-center justify-between group">
            <div class="flex items-center gap-4">
                <img src="{{ $membre->photo ? asset('storage/'.$membre->photo) : 'https://ui-avatars.com' . urlencode($membre->prenom . ' ' . $membre->nom) . '&background=f8fafc&color=6366f1' }}"
                     class="w-12 h-12 rounded-2xl object-cover shadow-sm border-2 border-white group-hover:scale-105 transition-transform">
                <div>
                    <p class="text-sm font-black text-slate-900 uppercase tracking-tighter">{{ $membre->prenom }} {{ $membre->nom }}</p>
                    <p class="text-[10px] font-bold text-indigo-500 uppercase italic">{{ $membre->fonction }}</p>
                </div>
            </div>
            <a href="tel:{{ $membre->telephone }}" class="p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </a>
        </div>
    @endforeach
</div>
