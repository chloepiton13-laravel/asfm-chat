<div class="max-w-4xl mx-auto glass p-8 md:p-16 rounded-[3rem] relative z-10 border-amber-500/20 shadow-2xl">
    <!-- En-tête -->
    <div class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-black tracking-tighter mb-4 italic uppercase">
            REJOINS <span class="text-amber-500 font-outline">L'ÉLITE</span>
        </h2>
        <p class="text-slate-400 font-light tracking-widest text-sm uppercase">Sélection officielle Mont-Ngafula</p>
    </div>

    <!-- Message de Succès (Alpine.js + Livewire) -->
    @if($success)
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             class="mb-8 bg-amber-500 text-slate-950 p-6 rounded-2xl font-black text-center shadow-[0_0_30px_rgba(245,158,11,0.4)]">
            ⚽ CANDIDATURE BIEN REÇUE ! ON ANALYSE TON TALENT.
        </div>
    @endif

    <!-- Formulaire -->
    <style>
        @keyframes shimmer {
            100% { transform: translateX(250%) skewX(-45deg); }
        }
    </style>
</div>
