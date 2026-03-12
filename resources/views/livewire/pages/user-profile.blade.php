<div class="min-h-screen pt-32 pb-20 px-6 relative overflow-hidden bg-slate-950">
    <!-- Effets de fond (Z-index 0) -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 blur-[120px] rounded-full pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-slate-800/20 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        <!-- HEADER PROFIL -->
        <div class="glass p-8 md:p-12 rounded-lg border-amber-500/20 mb-8 flex flex-col md:flex-row items-center gap-8 shadow-2xl">
            <div class="relative group">
                <div class="w-32 h-32 bg-amber-500 rounded-lg flex items-center justify-center text-slate-950 text-5xl font-black shadow-2xl shadow-amber-500/20 group-hover:scale-105 transition-transform duration-500">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <button class="absolute -bottom-2 -right-2 bg-slate-900 p-2 rounded-lg border border-white/10 hover:text-amber-500 transition-all shadow-xl">
                    <svg xmlns="http://www.w3.org" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </button>
            </div>

            <div class="text-center md:text-left flex-1">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                    <h1 class="text-4xl font-black uppercase tracking-tighter text-white">{{ $user->name }}</h1>
                    <span class="px-3 py-1 bg-amber-500/10 text-amber-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-amber-500/20 italic">Membre Officiel</span>
                </div>
                <p class="text-slate-400 font-medium tracking-wide">{{ $user->email }}</p>

                <div class="flex gap-6 mt-6">
                    <div>
                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">Inscrit depuis</p>
                        <p class="font-bold text-white">{{ $user->created_at->format('M Y') }}</p>
                    </div>
                    <div class="border-l border-white/10 pl-6">
                        <p class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1">Statut Chat</p>
                        <p class="font-bold text-green-500 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> En ligne
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 w-full md:w-auto">
                <a href="{{ route('chat') }}" class="px-6 py-3 bg-white/5 hover:bg-amber-500 hover:text-slate-950 border border-white/10 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all text-center">Mes Messages</a>
                <button wire:click="setTab('infos')" class="px-6 py-3 bg-amber-500 text-slate-950 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-amber-400 transition transform hover:scale-[1.02] shadow-lg shadow-amber-500/20">Modifier Profil</button>
            </div>
        </div>

        <!-- GRILLE INFOS -->
        <div class="grid md:grid-cols-3 gap-8">
            <!-- MENU LATÉRAL -->
            <div class="md:col-span-1 space-y-4">
                <div class="glass p-4 rounded-lg border-white/5">
                    <button wire:click="setTab('infos')" :class="$wire.tab === 'infos' ? 'bg-amber-500 text-slate-950' : 'text-white hover:bg-white/5'" class="w-full text-left px-5 py-4 rounded-lg transition text-xs font-black uppercase tracking-widest flex items-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informations
                    </button>
                    <button wire:click="setTab('security')" :class="$wire.tab === 'security' ? 'bg-amber-500 text-slate-950' : 'text-white hover:bg-white/5'" class="w-full text-left px-5 py-4 rounded-lg transition text-xs font-black uppercase tracking-widest flex items-center gap-3 mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Sécurité
                    </button>
                </div>
            </div>

            <!-- CONTENU DYNAMIQUE -->
            <div class="md:col-span-2">
                @if($tab === 'infos')
                <div class="glass p-8 rounded-lg border-white/5 animate-fade-in">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-amber-500 mb-8 border-b border-white/5 pb-4">Paramètres du compte</h3>
                    <form wire:submit.prevent="update" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-500 ml-2 tracking-widest">Pseudo ASFM</label>
                                <input type="text" value="{{ $user->name }}" class="w-full bg-slate-950/50 border border-white/10 rounded-lg px-5 py-4 outline-none focus:border-amber-500 transition text-white">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase text-slate-500 ml-2 tracking-widest">Email Contact</label>
                                <input type="email" value="{{ $user->email }}" class="w-full bg-slate-950/50 border border-white/10 rounded-lg px-5 py-4 outline-none focus:border-amber-500 transition text-white">
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-10 py-4 bg-white text-slate-950 font-black text-[10px] uppercase tracking-widest rounded-lg hover:bg-amber-500 transition-all transform hover:scale-105 shadow-xl">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                @if($tab === 'security')
                <div class="glass p-8 rounded-lg border-white/5 animate-fade-in">
                    <h3 class="text-xs font-black uppercase tracking-[0.2em] text-amber-500 mb-8 border-b border-white/5 pb-4">Sécurité & Accès</h3>
                    <div class="space-y-4">
                        <div class="p-6 rounded-lg bg-white/5 border border-white/10 flex justify-between items-center">
                            <div>
                                <p class="text-white font-bold text-sm uppercase italic">Mot de passe</p>
                                <p class="text-slate-500 text-[10px] uppercase mt-1">Dernière modification il y a 3 mois</p>
                            </div>
                            <button class="px-4 py-2 border border-white/20 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-slate-950 transition">Modifier</button>
                        </div>
                        <div class="p-6 rounded-lg bg-white/5 border border-white/10 flex justify-between items-center">
                            <div>
                                <p class="text-white font-bold text-sm uppercase italic">Double Authentification (2FA)</p>
                                <p class="text-red-500 text-[10px] font-bold uppercase mt-1">Désactivé</p>
                            </div>
                            <button class="px-4 py-2 bg-amber-500 text-slate-950 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-amber-400 transition">Activer</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
