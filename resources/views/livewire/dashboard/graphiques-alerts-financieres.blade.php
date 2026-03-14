<div class="lg:col-span-2 relative bg-[#050714] p-8 rounded-[2.5rem] border border-white/5 transition-all duration-700 hover:bg-white hover:border-slate-100 group overflow-hidden"
     wire:ignore
     x-data="{ stats: @js($stats) }"
     x-init="initAceChart(stats)">

    <div class="relative z-10">
        <div class="flex justify-between items-center mb-10">
            <h4 class="text-2xl font-black italic uppercase tracking-tighter text-white group-hover:text-slate-900 transition-colors">Analyse Flux</h4>
            <div class="flex gap-4 text-[9px] font-black uppercase italic">
                <span class="text-indigo-400 group-hover:text-indigo-600 tracking-widest">• Current</span>
                <span class="text-white/20 group-hover:text-slate-300 tracking-widest">• Prior</span>
            </div>
        </div>

        <div class="h-64">
            <canvas id="comparisonChart"></canvas>
        </div>
    </div>
</div>

<script>
function initAceChart(data) {
    const ctx = document.getElementById('comparisonChart').getContext('2d');

    // Création du dégradé émeraude/indigo Ace Berg
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.2)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.current,
                borderColor: '#6366f1',
                borderWidth: 4,
                fill: true,
                backgroundColor: gradient,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#6366f1',
                pointHoverBorderWidth: 3
            }, {
                data: data.prior,
                borderColor: 'rgba(255,255,255,0.05)',
                borderWidth: 2,
                borderDash: [5, 5],
                fill: false,
                tension: 0.4,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: 'rgba(255,255,255,0.2)', font: { size: 9, weight: '900' } }
                },
                y: { display: false }
            }
        }
    });

    // Logique d'Inversion Ace Berg
    const container = document.querySelector('.group');
    container.addEventListener('mouseenter', () => {
        chart.data.datasets[1].borderColor = '#e2e8f0';
        chart.options.scales.x.ticks.color = '#94a3b8';
        chart.update('none');
    });
    container.addEventListener('mouseleave', () => {
        chart.data.datasets[1].borderColor = 'rgba(255,255,255,0.05)';
        chart.options.scales.x.ticks.color = 'rgba(255,255,255,0.2)';
        chart.update('none');
    });
}
</script>
