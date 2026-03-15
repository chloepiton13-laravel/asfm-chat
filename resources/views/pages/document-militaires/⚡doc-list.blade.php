<?php

use App\Models\DocumentMilitary;
use Livewire\Component; // <--- Changement ici (v4 standard)
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Title};

new #[Layout('layouts::army-app', ['title' => 'Liste documents'])] class extends Component { // <--- Toujours 'extends Component'
    use WithPagination;

    public $search = '';

    // Utilisation de la méthode with() pour passer les données à la vue
    public function with(): array
    {
        return [
            'documents' => DocumentMilitary::query()
                ->where('objet', 'like', "%{$this->search}%")
                ->orWhere('reference_interne', 'like', "%{$this->search}%")
                ->latest()
                ->paginate(10),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        DocumentMilitary::find($id)->delete();
        // Optionnel : session()->flash('message', 'Document supprimé');
    }
};
?>


<div class="space-y-6" x-data="{ showModal: false, pdfUrl: '', showDeleteModal: false, deleteId: null, deleteRef: '' }">

  <!-- BARRE D'OPÉRATIONS SUPÉRIEURE -->
  <div class="flex flex-col xl:flex-row justify-between items-end gap-6 bg-slate-900/40 p-6 border border-slate-800/60 backdrop-blur-md shadow-2xl relative overflow-hidden">
      <!-- Accent Line -->
      <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>

      <div class="w-full xl:w-auto">
          <h1 class="text-4xl font-black uppercase italic tracking-tighter text-white drop-shadow-2xl">
              Archive <span class="text-emerald-500">Militaire</span>
          </h1>
          <div class="flex items-center gap-2 mt-1">
              <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
              <p class="text-[10px] font-mono font-bold text-slate-500 uppercase tracking-[0.3em]">Registry Status: Secure Access Only</p>
          </div>
      </div>

      <div class="flex flex-wrap items-center gap-4 w-full xl:w-auto">
          <!-- FILTRE DATE TACTIQUE AJUSTÉ -->
          <div class="group relative flex items-center bg-black/40 border border-slate-800 rounded-sm p-0.5 shadow-inner transition-all focus-within:border-emerald-500/50">
              <div class="flex items-center px-2">
                  <input type="date" wire:model.live="date_start"
                      class="bg-transparent border-none text-[10px] font-mono font-black text-emerald-400 focus:ring-0 uppercase cursor-pointer p-2 placeholder-slate-700">
                  <span class="text-[9px] font-black text-slate-600 px-2 italic tracking-widest">TO_DATE</span>
                  <input type="date" wire:model.live="date_end"
                      class="bg-transparent border-none text-[10px] font-mono font-black text-emerald-400 focus:ring-0 uppercase cursor-pointer p-2 placeholder-slate-700">
              </div>
              <!-- Bottom line glow -->
              <div class="absolute bottom-0 left-0 h-[1px] w-0 bg-emerald-500 group-focus-within:w-full transition-all duration-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
          </div>

          <!-- RECHERCHE AVEC GLOW -->
          <div class="relative flex-grow md:w-80 group border-slate-800">
              <input
                  wire:model.live.debounce.300ms="search"
                  type="search"
                  placeholder="SCAN_IDENTIFIANT // OBJET_SUBJECT..."
                  class="w-full bg-black/40 border-slate-800 rounded-sm pl-10 pr-4 py-3 text-[10px] font-mono font-black uppercase tracking-[0.2em] text-emerald-400 placeholder-slate-700 focus:border-emerald-500/50 focus:ring-0 focus:bg-black/60 transition-all duration-300 shadow-inner"
              >

              <!-- Icône de scan animée -->
              <div class="absolute left-3 top-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none">
                  <svg class="w-4 h-4 text-slate-600 group-focus-within:text-emerald-500 group-focus-within:drop-shadow-[0_0_5px_rgba(16,185,129,0.7)] transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
              </div>

              <div class="absolute bottom-0 left-0 h-[1px] w-0 bg-emerald-500 group-focus-within:w-full transition-all duration-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
          </div>

          <!-- BOUTON ADDITION -->
          <a href="{{ route('documents.military.create') }}" wire:navigate
             class="bg-emerald-600 hover:bg-emerald-500 text-black px-8 py-3 rounded-sm font-black uppercase text-[10px] tracking-[0.2em] transition-all shadow-[0_0_20px_rgba(16,185,129,0.2)] hover:shadow-[0_0_30px_rgba(16,185,129,0.4)] active:scale-95 border-b-2 border-emerald-800/50 hover:border-emerald-400/50">
              EXEC_ENTRY
          </a>
      </div>
  </div>

    <!-- TABLEAU DE COMMANDEMENT -->
    <div class="bg-slate-950 border border-slate-800 rounded-sm shadow-2xl relative">
        <table class="min-w-full divide-y divide-slate-800">
            <thead class="bg-slate-900/80">
                <tr class="text-[10px] font-mono font-bold uppercase tracking-[0.2em] text-slate-500">
                    <th class="px-6 py-5 text-left border-r border-slate-800/40">Reference_ID</th>
                    <th class="px-6 py-5 text-left">Subject_Classification</th>
                    <th class="px-6 py-5 text-left">Origin_Dest</th>
                    <th class="px-6 py-5 text-center">Status_Code</th>
                    <th class="px-6 py-5 text-right">Admin_Auth</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-900 bg-black/20">
                @forelse ($documents as $doc)
                    <tr wire:key="{{ $doc->id }}" class="hover:bg-emerald-500/5 transition-all group border-l-2 border-l-transparent hover:border-l-emerald-500">
                        <td class="px-6 py-5">
                            <span class="font-mono text-xs font-bold text-emerald-500/80 group-hover:text-emerald-400 tracking-wider transition-colors italic">#{{ $doc->reference_interne }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="mb-1.5 flex items-center gap-2">
                                <span class="text-[8px] font-black uppercase px-2 py-0.5 rounded-sm border leading-none
                                    {{ in_array($doc->classification, ['Secret', 'Très Secret']) ? 'bg-red-500/10 text-red-500 border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.1)]' : 'bg-slate-800 text-slate-400 border-slate-700' }}">
                                    {{ $doc->classification }}
                                </span>
                            </div>
                            <div class="text-sm font-bold text-slate-100 uppercase tracking-tight group-hover:text-white transition-colors">{{ $doc->objet }}</div>
                        </td>
                        <td class="px-6 py-5 font-mono text-[10px] font-bold text-slate-500 uppercase tracking-tighter">
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-500/40 font-black">SRC_</span>
                                <span class="text-slate-300">{{ $doc->unite_emetteur }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-blue-500/40 font-black">DST_</span>
                                <span class="text-slate-300">{{ $doc->unite_destinataire }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 rounded-sm text-[9px] font-mono font-black uppercase border transition-all {{ $doc->statut === 'Transmis' ? 'text-emerald-400 border-emerald-500/30 bg-emerald-500/10 shadow-[0_0_10px_rgba(16,185,129,0.1)]' : 'text-slate-600 border-slate-800 bg-slate-900' }}">
                                [ {{ $doc->statut }} ]
                            </span>
                        </td>
                        <td class="px-6 py-5 text-right whitespace-nowrap">
                            <div class="flex justify-end gap-2 opacity-40 group-hover:opacity-100 transition-opacity">

                              <!-- 1. VOIR : Détails complets (Modale Métadonnées) -->
                              <button @click="selectedDoc = @js($doc); showViewModal = true"
                                      class="p-2 text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded-sm transition-all duration-300"
                                      title="CONSULTER_LOG">
                                  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                  </svg>
                              </button>

                                <!-- SCAN : Aperçu PDF -->
                                @if($doc->fichier_joint)
                                    <button @click="pdfUrl = '{{ Storage::url($doc->fichier_joint) }}'; showModal = true"
                                            class="p-2 text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 rounded-sm transition"
                                            title="VIEW_SCAN">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                @endif

                                <!-- EDIT : Rectifier -->
                                <a href="{{ route('documents.military.edit', $doc) }}"
                                   wire:navigate
                                   class="p-2 text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 rounded-sm transition"
                                   title="EDIT_DATA">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <!-- PURGE : Détruire -->
                                <button @click="deleteId = {{ $doc->id }}; deleteRef = '{{ $doc->reference_interne }}'; showDeleteModal = true"
                                        class="p-2 text-slate-600 hover:text-red-500 hover:bg-red-500/10 rounded-sm transition"
                                        title="PURGE_ARCHIVE">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-32 text-center bg-slate-900/20">
                            <div class="flex flex-col items-center opacity-20">
                                <svg class="w-20 h-20 mb-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span class="text-xs font-mono font-black uppercase tracking-[0.5em] text-white">No Data Detected In Registry</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION TACTIQUE -->
    <div class="mt-8">
        {{ $documents->links('livewire::tactical-pagination') }}
    </div>

    <!-- LES MODALES RESTENT LES MÊMES MAIS AVEC DES COINS DROITS -->
    <!-- MODALE APERÇU PDF -->
    <div x-show="showModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/95 backdrop-blur-md"
         x-cloak>

        <div @click.away="showModal = false" class="bg-black border border-slate-800 rounded-sm shadow-[0_0_50px_rgba(0,0,0,1)] w-full max-w-6xl h-[92vh] flex flex-col overflow-hidden">
            <!-- Barre de titre Modale -->
            <div class="px-6 py-4 border-b border-slate-800 flex justify-between items-center bg-slate-900/50">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                    <h3 class="text-[10px] font-mono font-black uppercase tracking-[0.3em] text-emerald-500">Secure_Viewer_Terminal // Live_Stream</h3>
                </div>
                <button @click="showModal = false" class="text-slate-500 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Conteneur Iframe -->
            <div class="flex-grow bg-slate-950 relative">
                <!-- Loading Indicator -->
                <div class="absolute inset-0 flex items-center justify-center -z-10">
                    <span class="text-xs font-mono animate-pulse text-slate-700 uppercase tracking-widest">Loading encrypted data...</span>
                </div>
                <template x-if="pdfUrl">
                    <iframe :src="pdfUrl" class="w-full h-full border-none grayscale-[0.2] invert-[0.05]"></iframe>
                </template>
            </div>

            <!-- Footer Modale -->
            <div class="px-6 py-3 border-t border-slate-800 bg-slate-900/30 flex justify-end">
                <button @click="showModal = false" class="px-6 py-2 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition">Close_Stream</button>
            </div>
        </div>
    </div>
    <!-- MODALE CONFIRMATION SUPPRESSION -->
    <div x-show="showDeleteModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-lg"
         x-cloak>

        <div @click.away="showDeleteModal = false" class="bg-slate-950 border border-red-900/50 rounded-sm p-8 max-w-sm w-full text-center relative overflow-hidden shadow-[0_0_60px_rgba(185,28,28,0.1)]">
            <!-- Warning Bar -->
            <div class="absolute top-0 left-0 w-full h-1 bg-red-600 shadow-[0_0_15px_rgba(220,38,38,0.8)]"></div>

            <div class="mb-6">
                <svg class="w-12 h-12 text-red-600 mx-auto animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="text-red-500 font-mono font-black uppercase tracking-[0.2em] text-lg mb-4 italic">Critical_Purge_Protocol</h3>

            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-8 leading-relaxed">
                Attention : Cette opération effacera définitivement l'identifiant <br>
                <span class="text-white mt-3 block font-mono bg-red-900/30 p-2 border border-red-800/50 rounded-sm" x-text="deleteRef"></span>
            </p>

            <div class="grid grid-cols-2 gap-4">
                <button @click="showDeleteModal = false"
                        class="px-4 py-3 border border-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white hover:bg-slate-900 transition rounded-sm">
                    Abort_Cmd
                </button>
                <button @click="$wire.delete(deleteId); showDeleteModal = false"
                        class="px-4 py-3 bg-red-600 text-white text-[10px] font-black uppercase tracking-widest hover:bg-red-500 transition rounded-sm shadow-[0_0_20px_rgba(220,38,38,0.3)]">
                    Confirm_Purge
                </button>
            </div>
        </div>
    </div>

    <!-- MODALE CONSULTATION DÉTAILLÉE -->
    <div x-show="showViewModal"
         x-transition.opacity
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/95 backdrop-blur-md"
         x-cloak>

        <div @click.away="showViewModal = false"
             class="bg-slate-950 border border-slate-800 rounded-sm shadow-[0_0_50px_rgba(0,0,0,1)] max-w-2xl w-full overflow-hidden relative">

            <!-- Scanner Effect Line -->
            <div class="absolute top-0 left-0 w-full h-[2px] bg-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.5)]"></div>

            <!-- Header -->
            <div class="px-6 py-4 border-b border-slate-800 bg-slate-900/50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                    <h3 class="text-[10px] font-mono font-black uppercase tracking-[0.3em] text-emerald-500 italic">Document_Metadata_Viewer // Access_Granted</h3>
                </div>
                <button @click="showViewModal = false" class="text-slate-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <label class="text-[9px] font-black text-slate-600 uppercase tracking-widest block mb-1 underline decoration-slate-800 underline-offset-4">Identifiant_Unique</label>
                        <div class="font-mono text-emerald-500 font-bold text-sm tracking-wider" x-text="selectedDoc?.reference_interne || '---'"></div>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-600 uppercase tracking-widest block mb-1 underline decoration-slate-800 underline-offset-4">Niveau_Classification</label>
                        <div class="text-[10px] font-black uppercase px-2 py-1 rounded-sm border inline-block tracking-tighter"
                             :class="['Secret', 'Très Secret'].includes(selectedDoc?.classification) ? 'bg-red-950 text-red-500 border-red-900' : 'bg-slate-900 text-slate-400 border-slate-700'"
                             x-text="selectedDoc?.classification || 'NON_CLASSÉ'"></div>
                    </div>
                </div>

                <div class="bg-slate-900/30 p-4 border border-slate-800/50">
                    <label class="text-[9px] font-black text-slate-600 uppercase tracking-widest block mb-2 underline decoration-slate-800 underline-offset-4">Objet_Du_Document // Subject</label>
                    <div class="text-sm font-bold text-white uppercase tracking-tight leading-relaxed" x-text="selectedDoc?.objet || 'SANS_OBJET'"></div>
                </div>

                <div class="grid grid-cols-2 gap-8 border-t border-slate-900 pt-6">
                    <div>
                        <label class="text-[9px] font-black text-emerald-900 uppercase tracking-widest block mb-1 italic">Unité_Émettrice [SRC]</label>
                        <div class="text-xs font-bold text-slate-300 font-mono uppercase" x-text="selectedDoc?.unite_emetteur || '---'"></div>
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-blue-900 uppercase tracking-widest block mb-1 italic">Unité_Destinataire [DST]</label>
                        <div class="text-xs font-bold text-slate-300 font-mono uppercase" x-text="selectedDoc?.unite_destinataire || '---'"></div>
                    </div>
                </div>

                <div class="bg-black/40 p-5 border-l-2 border-emerald-600 rounded-sm shadow-inner relative overflow-hidden">
                    <!-- Decorative background code -->
                    <div class="absolute right-2 bottom-0 opacity-[0.03] text-[40px] font-black text-emerald-500 select-none font-mono">SIG_AUTH</div>

                    <label class="text-[9px] font-black text-slate-600 uppercase tracking-widest block mb-3">Signature_Autorité_Validation</label>
                    <div class="flex items-center gap-3 relative z-10">
                        <span class="text-[10px] font-mono font-black text-emerald-600 bg-emerald-500/5 px-2 py-0.5 border border-emerald-500/20" x-text="selectedDoc?.grade_signataire || '---'"></span>
                        <span class="text-sm font-black text-white uppercase tracking-tighter" x-text="selectedDoc?.nom_signataire || 'SIGNATURE_MANQUANTE'"></span>
                    </div>
                    <div class="text-[9px] font-mono text-slate-600 mt-2 italic flex items-center gap-2">
                        <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                        <span x-text="`Date d'approbation : ${selectedDoc?.date_signature || 'DATE_NON_DÉFINIE'}`"></span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-slate-900/30 flex justify-end gap-3 border-t border-slate-800">
                <button @click="showViewModal = false"
                        class="px-8 py-2 text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-all hover:bg-slate-800 rounded-sm border border-transparent hover:border-slate-700">
                    Close_Terminal
                </button>
            </div>
        </div>
    </div>
</div>


</div>
