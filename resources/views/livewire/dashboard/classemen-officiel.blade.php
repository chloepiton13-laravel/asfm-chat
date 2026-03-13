<!-- BLOC GAUCHE : LE CLASSEMENT GÉNÉRAL (2/3) -->
<div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
        <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest italic flex items-center">
            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Classement Officiel ASFM
        </h4>
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter italic">Saison en cours</span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
          <thead>
              <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                  <th class="px-6 py-4 text-center">#</th>
                  <th class="px-6 py-4">Équipe</th>

                  <!-- Tooltips sur les stats -->
                  <th class="px-4 py-4 text-center cursor-help" title="Matchs Joués">MJ</th>
                  <th class="px-4 py-4 text-center text-emerald-600 cursor-help" title="Victoires">V</th>
                  <th class="px-4 py-4 text-center cursor-help" title="Matchs Nuls">N</th>
                  <th class="px-4 py-4 text-center text-red-500 cursor-help" title="Défaites">D</th>
                  <th class="px-4 py-4 text-center cursor-help" title="Différence de buts">Diff</th>

                  <!-- Nouvelle colonne Forme -->
                  <th class="px-4 py-4 text-center cursor-help" title="5 derniers matchs">Forme</th>

                  <th class="px-6 py-4 text-center bg-slate-50/50 cursor-help" title="Points cumulés">Pts</th>
              </tr>
          </thead>
          <tbody class="divide-y divide-slate-50">
              @php $totalRows = count($standings); @endphp
              @foreach($standings as $index => $row)
                  @php
                      $isLeader = ($index === 0);
                      $isRelegation = ($index >= $totalRows - 2 && $totalRows > 2);
                  @endphp

                  <tr class="hover:bg-slate-50/50 transition-colors group relative
                      {{ $isLeader ? 'bg-amber-50/30' : '' }}
                      {{ $isRelegation ? 'bg-red-50/30' : '' }}">

                      <!-- Indicateur de Position -->
                      <td class="px-6 py-4 text-center relative">
                          @if($isLeader)
                              <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-400"></div>
                              <span class="text-sm font-black text-amber-500 italic">01</span>
                          @elseif($isRelegation)
                              <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500"></div>
                              <span class="text-xs font-black text-red-500 italic">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                          @else
                              <span class="text-[10px] font-black text-slate-300 group-hover:text-indigo-600 italic">
                                  {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                              </span>
                          @endif
                      </td>

                      <td class="px-6 py-4">
                          <div class="flex items-center gap-3">
                              <span class="text-sm font-black {{ $isRelegation ? 'text-red-900/80' : 'text-slate-700' }} uppercase tracking-tighter">
                                  {{ $row->equipe->nom ?? 'Équipe Inconnue' }}
                              </span>
                              @if($isLeader)
                                  <span class="text-[7px] px-1.5 py-0.5 bg-amber-400 text-white rounded font-black uppercase tracking-widest animate-pulse">Leader</span>
                              @endif
                              @if($isRelegation)
                                  <span class="text-[7px] px-1.5 py-0.5 bg-red-500 text-white rounded font-black uppercase tracking-widest">Relégation</span>
                              @endif
                          </div>
                      </td>

                      <!-- Stats -->
                      <td class="px-4 py-4 text-center text-xs font-bold text-slate-500">{{ $row->played }}</td>
                      <td class="px-4 py-4 text-center text-xs font-black text-emerald-600">{{ $row->wins }}</td>
                      <td class="px-4 py-4 text-center text-xs font-bold text-slate-500">{{ $row->draws }}</td>
                      <td class="px-4 py-4 text-center text-xs font-bold text-red-400">{{ $row->losses }}</td>

                      <td class="px-4 py-4 text-center text-xs font-black {{ $row->goal_difference >= 0 ? 'text-slate-900' : 'text-red-500' }}">
                          {{ $row->goal_difference > 0 ? '+' : '' }}{{ $row->goal_difference }}
                      </td>

                      <!-- Visualisation de la Forme -->
                      <td class="px-4 py-4">
                          <div class="flex items-center justify-center gap-1">
                              {{-- Logique : $row->last_five est un tableau ex: ['V', 'D', 'N', 'V', 'V'] --}}
                              @foreach($row->form_array ?? ['V', 'N', 'D', 'V', 'V'] as $result)
                                  <span @class([
                                      'w-2 h-2 rounded-full',
                                      'bg-emerald-500' => $result === 'V',
                                      'bg-slate-300' => $result === 'N',
                                      'bg-red-500' => $result === 'D',
                                  ]) title="{{ $result === 'V' ? 'Victoire' : ($result === 'N' ? 'Nul' : 'Défaite') }}"></span>
                              @endforeach
                          </div>
                      </td>

                      <!-- Points Badge -->
                      <td class="px-6 py-4 text-center {{ $isLeader ? 'bg-amber-100/20' : ($isRelegation ? 'bg-red-100/20' : 'bg-slate-50/30') }}">
                          <span class="inline-block px-3 py-1 rounded-lg text-sm font-black shadow-md italic text-white
                              {{ $isLeader ? 'bg-amber-500 shadow-amber-200' : ($isRelegation ? 'bg-red-500 shadow-red-100' : 'bg-indigo-600 shadow-indigo-100') }}">
                              {{ $row->points }}
                          </span>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
    </div>
</div>
