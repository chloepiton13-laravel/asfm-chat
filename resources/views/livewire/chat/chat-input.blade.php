<footer class="p-4 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 relative">
  {{-- Picker Emoji (inchangé) --}}
  <input class="hidden peer" id="emoji-toggle" type="checkbox"/>
  <div class="hidden absolute bottom-[100%] left-4 mb-2 peer-checked:flex ..." id="emoji-picker">
     <!-- ... contenu emoji ... -->
  </div>

  {{-- Aperçu du fichier avant envoi --}}
  @if($file)
    <div class="absolute bottom-20 left-4 bg-white dark:bg-slate-800 p-2 rounded-lg shadow-xl border border-slate-200 dark:border-slate-700 flex items-center gap-3 z-10 animate-in fade-in slide-in-from-bottom-2">
      <div class="h-10 w-10 bg-primary/10 rounded flex items-center justify-center text-primary">
        <span class="material-symbols-outlined">description</span>
      </div>
      <div class="flex flex-col">
        <span class="text-xs font-medium text-slate-900 dark:text-white truncate max-w-[120px]">{{ $file->getClientOriginalName() }}</span>
        <span class="text-[10px] text-slate-500">{{ round($file->getSize() / 1024, 1) }} KB</span>
      </div>
      <button wire:click="$set('file', null)" class="text-slate-400 hover:text-red-500 transition-colors">
        <span class="material-symbols-outlined text-sm">close</span>
      </button>
    </div>
  @endif

  <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 p-2 rounded-xl focus-within:ring-2 focus-within:ring-primary/20 transition-all relative">
    <label class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:text-primary transition-colors cursor-pointer" for="emoji-toggle">
      <span class="material-symbols-outlined">mood</span>
    </label>

    {{-- Bouton Attach File avec Input invisible --}}
    <label class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 hover:text-primary transition-colors cursor-pointer relative">
      <span class="material-symbols-outlined" wire:loading.remove wire:target="file">attach_file</span>
      {{-- Spinner pendant l'upload temporaire --}}
      <div wire:loading wire:target="file" class="h-4 w-4 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
      <input type="file" wire:model="file" class="hidden">
    </label>

    <textarea
        wire:model="body"
        wire:keydown.enter.prevent="sendMessage"
        class="flex-1 border-none bg-transparent focus:ring-0 text-sm resize-none py-2 placeholder:text-slate-400"
        placeholder="Écrivez un message..."
        rows="1">
    </textarea>

    <button
        wire:click="sendMessage"
        wire:loading.attr="disabled"
        @disabled(!$selectedConversationId || (empty(trim($body)) && !$file))
        class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary text-white shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all disabled:opacity-50">
      <span class="material-symbols-outlined" wire:loading.remove wire:target="sendMessage">send</span>
      <div wire:loading wire:target="sendMessage" class="h-4 w-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
    </button>
  </div>
</footer>
