{{-- resources/views/auth/confirm-password.blade.php --}}

<x-layouts::auth-app>
<div class="flex-1 flex items-center justify-center p-6 bg-[#050714]">
    <div class="w-full max-w-[440px] relative">

        <!-- EFFET DE LUEUR (AMBRE POUR LA CONFIRMATION) -->
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-amber-500/10 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- Header Ace Berg -->
        <div class="relative z-10 mb-12 text-center">
            <p class="text-amber-500 text-[10px] font-black uppercase tracking-[0.5em] italic mb-3">Identification Requise</p>
            <h1 class="text-4xl font-black text-white italic uppercase tracking-tighter leading-none">Validation</h1>
            <p class="text-slate-500 mt-4 text-[11px] font-bold uppercase tracking-widest leading-relaxed px-10">
                Veuillez confirmer votre mot de passe pour accéder aux paramètres de sécurité.
            </p>
        </div>

        <!-- Card Ace Berg -->
        <div class="relative bg-[#0A0D2E]/40 backdrop-blur-xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">

          {{-- Dans ton fichier d'onglet sécurité --}}
          <form method="POST" action="{{ url('/user/two-factor-authentication') }}" wire:submit.prevent="">
              @csrf
              {{-- On utilise onclick pour forcer la soumission du formulaire parent si Livewire bloque --}}
              <button type="submit"
                      onclick="this.closest('form').submit();"
                      class="px-4 py-2 bg-amber-500 text-slate-950 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-amber-400 transition">
                  Activer
              </button>
          </form>
        </div>

        <!-- Footer Branding -->
        <p class="mt-10 text-center text-[8px] font-black text-white/10 uppercase tracking-[0.8em]">Ace Berg Secure Protocol</p>
    </div>
</div>

<style>
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(200%); }
}
</style>
</x-layouts::auth-app>
