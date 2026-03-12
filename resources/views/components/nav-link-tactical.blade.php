@php $isActive = request()->routeIs($item['route']); @endphp

<a href="{{ route($item['route']) }}"
   class="group flex items-center gap-4 px-5 py-3.5 rounded-2xl transition-all duration-500
   {{ $isActive
        ? 'bg-white shadow-[0_20px_40px_-10px_rgba(245,158,11,0.25)] text-slate-950 scale-[1.02] translate-x-1'
        : 'text-slate-500 hover:bg-white/5 hover:text-white hover:translate-x-1'
   }}">

    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
         class="w-5 h-5 transition-colors duration-500 {{ $isActive ? 'text-amber-600' : 'text-slate-700 group-hover:text-amber-400' }}">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
    </svg>

    <span class="text-[13px] font-black uppercase tracking-tight">{{ $item['label'] }}</span>

    @if($isActive)
        <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 ml-auto text-amber-600">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    @endif
</a>
