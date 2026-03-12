@props(['icon', 'label', 'active' => false, 'sidebarOpen'])

<a href="#" {{ $attributes->merge() }}>
    <div class="min-w-[24px] flex justify-center text-lg">
        <i class="fa-solid {{ $icon }}"></i>
    </div>
    <span class="ml-4 font-bold text-xs uppercase tracking-wider whitespace-nowrap transition-opacity duration-300"
          x-show="sidebarOpen"
          x-transition:enter.delay.100ms>
        {{ $label }}
    </span>
</a>
