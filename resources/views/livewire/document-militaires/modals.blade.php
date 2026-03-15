<div x-data="{
    showView: @entangle('showView'),
    showScan: @entangle('showScan'),
    showDelete: @entangle('showDelete'),
    doc: @entangle('selectedDoc')
}">
    <!-- 1. MODALE CONSULTATION (DÉTAILS) -->
    <div x-show="showView" x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/95 backdrop-blur-md" x-cloak>
        <div @click.away="showView = false" class="bg-slate-950 border border-slate-800 rounded-sm shadow-2xl max-w-2xl w-full overflow-hidden relative">
            <div class="px-6 py-4 border-b border-slate-800 bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-[10px] font-mono font-black uppercase tracking-[0.3em] text-emerald-500">Metadata_Viewer // Access_Granted</h3>
                <button @click="showView = false" class="text-slate-500 hover:text-white transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="text-[9px] font-black text-slate-600 uppercase block mb-1">Identifiant</label>
                        <div class="font-mono text-emerald-500 font-bold" x-text="doc?.reference_interne"></div>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-600 uppercase block mb-1">Classification</label>
                        <div class="text-[10px] font-black uppercase px-2 py-0.5 rounded-sm border inline-block" :class="doc?.classification === 'Secret' ? 'bg-red-950 text-red-500 border-red-900' : 'bg-slate-900 text-slate-400 border-slate-700'" x-text="doc?.classification"></div>
                    </div>
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-600 uppercase block mb-1">Objet_Subject</label>
                    <div class="text-sm font-bold text-white uppercase" x-text="doc?.objet"></div>
                </div>
            </div>
            <div class="px-6 py-4 bg-slate-900/30 flex justify-end border-t border-slate-800">
                <button @click="showView = false" class="px-6 py-2 text-[10px] font-black uppercase text-slate-500 hover:text-white transition">Exit_Viewer</button>
            </div>
        </div>
    </div>

    <!-- 2. MODALE SCAN (PDF) -->
    <div x-show="showScan" x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/95 backdrop-blur-lg" x-cloak>
        <div @click.away="showScan = false" class="bg-black border border-slate-800 rounded-sm shadow-2xl w-full max-w-6xl h-[92vh] flex flex-col">
            <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900/50 text-[10px] font-mono font-black text-emerald-500 tracking-[0.3em]">
                <span>Secure_Viewer_Terminal // Live_Stream</span>
                <button @click="showScan = false" class="text-slate-500 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <div class="flex-grow bg-slate-950">
                <iframe :src="doc?.fichier_url" class="w-full h-full border-none grayscale-[0.2] invert-[0.05]"></iframe>
            </div>
        </div>
    </div>

    <!-- 3. MODALE PURGE (DELETE) -->
    <div x-show="showDelete" x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/90 backdrop-blur-lg" x-cloak>
        <div @click.away="showDelete = false" class="bg-slate-950 border border-red-900/50 rounded-sm p-8 max-w-sm w-full text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-red-600 shadow-[0_0_15px_rgba(220,38,38,0.8)]"></div>
            <h3 class="text-red-500 font-mono font-black uppercase tracking-[0.2em] mb-4 italic">Critical_Purge_Protocol</h3>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-8 leading-relaxed">Confirmez-vous la destruction définitive de :<br><span class="text-white mt-3 block font-mono bg-red-900/30 p-2 border border-red-800/50" x-text="doc?.reference_interne"></span></p>
            <div class="grid grid-cols-2 gap-4">
                <button @click="showDelete = false" class="px-4 py-3 border border-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition">Abort</button>
                <button wire:click="executeDelete" class="px-4 py-3 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-red-500 transition shadow-[0_0_20px_rgba(220,38,38,0.3)]">Confirm_Purge</button>
            </div>
        </div>
    </div>
</div>
