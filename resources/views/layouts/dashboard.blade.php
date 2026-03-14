<!DOCTYPE html>
<html lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>{{ $title ?? config('app.name') }}</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://unpkg.com" type="module"></script>

<!-- Script de capture -->
<script src="https://cdnjs.cloudflare.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com">
<script src="https://cdnjs.cloudflare.com"></script>


<script id="tailwind-config">
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        "primary": "#0fbd49",
                        "primary-dark": "#0d9a3c",
                        "background": "#F8F9FA",
                        "charcoal": "#2D3436",
                        "sidebar-border": "#E9ECEF"
                    },
                    fontFamily: {
                        "display": ["Lexend"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.02)',
                    }
                },
            },
        }
    </script>
    <style>
    @keyframes shimmer {
        0% { transform: translateX(-200%) skewX(-12deg); }
        100% { transform: translateX(400%) skewX(-12deg); }
    }
    </style>
<style type="text/tailwindcss">
        @layer base {
            body {
                @apply bg-background text-charcoal font-display transition-colors duration-300;
            }
        }.has-tooltip {
            position: relative;
        }
        .tooltip {
            visibility: hidden;
            position: absolute;
            top: 110%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #2D3436;
            color: white;
            text-align: center;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            white-space: nowrap;
            z-index: 50;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .has-tooltip:hover .tooltip {
            visibility: visible;
            opacity: 1;
        }



        /* Style de la scrollbar pour les navigateurs Chrome, Safari et Edge */
.overflow-y-auto::-webkit-scrollbar {
    width: 3px; /* Très fine */
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: transparent; /* Fond invisible */
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(245, 158, 11, 0.1); /* Ambre très discret */
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(245, 158, 11, 0.3); /* Un peu plus visible au survol */
}

/* Firefox */
.overflow-y-auto {
    scrollbar-width: thin;
    scrollbar-color: rgba(245, 158, 11, 0.1) transparent;
}

    </style>
    <style>
        /* Barre de défilement élégante */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
    <style>
        .font-outline-amber {
            -webkit-text-stroke: 1.5px #f59e0b;
            color: transparent;
        }
    </style>
      <style>
      @keyframes shimmer {
          100% { transform: translateX(300%); }
      }
      </style>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen">
  <div class="flex h-screen overflow-hidden bg-slate-50">
      <!-- Sidebar (Fixe à gauche) -->
      <livewire:dashboard.sidebar />

      <!-- Zone de droite (Header + Contenu) -->
      <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

          <!-- Header -->
          <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0">
              <div class="flex items-center gap-4">
                  <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">
                      {{ $title ?? 'Administration' }}
                  </h2>
              </div>

              <div class="flex items-center gap-4">
                  <!-- Notifications / Profil / Recherche -->
                  <button class="p-2 text-slate-400 hover:text-primary transition-colors">
                      <span class="material-symbols-outlined">notifications</span>
                  </button>

                  <div class="h-8 w-px bg-slate-200 mx-2"></div>

                  <div class="flex items-center gap-3">
                      <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                      <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                          <span class="material-symbols-outlined text-sm">person</span>
                      </div>
                  </div>
              </div>
          </header>

          <!-- Main Content (La zone qui scroll) -->
          <main class="flex-1 overflow-y-auto p-8">
              {{ $slot }}
          </main>

      </div>
  </div>

  <script>
  function downloadAsImage() {
      // 1. Identifiez le conteneur principal à capturer (ex: l'ID de votre carte de stats)
      // Assurez-vous d'ajouter id="capture-area" sur l'élément HTML parent souhaité
      const element = document.getElementById('capture-area') || document.body;

      // 2. Configuration et capture
      html2canvas(element, {
          backgroundColor: null, // Préserve la transparence si besoin
          scale: 2, // Améliore la qualité (Retina ready)
          logging: false,
          useCORS: true // Utile si vous avez des images provenant d'autres domaines
      }).then(canvas => {
          // 3. Création du lien de téléchargement
          const link = document.createElement('a');
          link.download = 'rapport-saison-23-24.png';
          link.href = canvas.toDataURL("image/png");
          link.click();
      });
  }
  </script>
  <script src="https://cdn.jsdelivr.net"></script>
  

  <script>
      document.addEventListener('livewire:navigated', () => {
          const ctx = document.getElementById('comparisonChart');
          if (!ctx) return;

          // Création du dégradé pour le mois présent
          const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
          gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)'); // Blue-600 avec opacité
          gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');   // Transparent

          new Chart(ctx, {
              type: 'line',
              data: {
                  labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'], // À adapter selon vos données
                  datasets: [
                      {
                          label: 'Mois Précédent',
                          data: [12000, 19000, 15000, 22000], // Exemple de données PHP
                          borderColor: '#cbd5e1', // Slate-300
                          borderWidth: 2,
                          borderDash: [5, 5],
                          pointRadius: 0,
                          fill: false,
                          tension: 0.4
                      },
                      {
                          label: 'Mois Actuel',
                          data: [15000, 25000, 18000, 30000], // Exemple de données PHP
                          borderColor: '#2563eb', // Blue-600
                          borderWidth: 3,
                          backgroundColor: gradient,
                          fill: true,
                          pointBackgroundColor: '#2563eb',
                          pointBorderColor: '#fff',
                          pointBorderWidth: 2,
                          pointRadius: 4,
                          pointHoverRadius: 6,
                          tension: 0.4
                      }
                  ]
              },
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                      legend: { display: false } // On utilise notre propre légende HTML
                  },
                  scales: {
                      y: {
                          beginAtZero: true,
                          grid: {
                              display: true,
                              color: '#f1f5f9', // Slate-100
                              drawBorder: false
                          },
                          ticks: {
                              color: '#94a3b8', // Slate-400
                              font: { size: 10, weight: '800' },
                              callback: (value) => value.toLocaleString() + ' FC'
                          }
                      },
                      x: {
                          grid: { display: false },
                          ticks: {
                              color: '#94a3b8', // Slate-400
                              font: { size: 10, weight: '800' }
                          }
                      }
                  },
                  interaction: {
                      intersect: false,
                      mode: 'index',
                  },
                  animation: {
                      duration: 2000,
                      easing: 'easeOutQuart'
                  }
              }
          });
      });
  </script>

<script>
/*
   FICHIER : resources/js/dashboard-charts.js
   Liaison : <canvas id="comparisonChart"></canvas>
*/

document.addEventListener('livewire:navigated', () => {
    const el = document.getElementById('comparisonChart');
    if (!el) return;

    const ctx = el.getContext('2d');
    const container = el.closest('.group'); // Cible le conteneur parent Ace Berg

    // Couleurs Ace Berg (Mode Sombre par défaut)
    const colors = {
        current: '#6366f1',      // Indigo Vibrant
        prior: 'rgba(255, 255, 255, 0.08)', // Blanc très discret
        text: 'rgba(255, 255, 255, 0.2)',
        // Mode Inverse (Hover)
        currentHover: '#4f46e5', // Indigo profond
        priorHover: '#e2e8f0',   // Gris clair (Ardoise)
        textHover: '#94a3b8'     // Gris texte
    };

    const config = {
        type: 'line',
        data: {
            labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN'],
            datasets: [
                {
                    label: 'Current',
                    data: [30, 45, 35, 60, 50, 70], // Vos données dynamiques ici
                    borderColor: colors.current,
                    borderWidth: 4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    pointBackgroundColor: colors.current,
                    tension: 0.4,
                },
                {
                    label: 'Prior',
                    data: [20, 35, 40, 45, 30, 55],
                    borderColor: colors.prior,
                    borderWidth: 2,
                    borderDash: [5, 5],
                    pointRadius: 0,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: colors.text,
                        font: { size: 9, weight: '900', family: 'Inter' }
                    }
                },
                y: { display: false } // Look Ace Berg : pas d'axe Y
            },
            interaction: { intersect: false, mode: 'index' }
        }
    };

    const chart = new Chart(ctx, config);

    // LOGIQUE D'INVERSION ACE BERG
    if (container) {
        container.addEventListener('mouseenter', () => {
            // Bascule vers le look "Papier"
            chart.data.datasets[1].borderColor = colors.priorHover;
            chart.data.datasets[0].borderColor = colors.currentHover;
            chart.options.scales.x.ticks.color = colors.textHover;
            chart.update('active'); // Update fluide
        });

        container.addEventListener('mouseleave', () => {
            // Retour au look "Abyssal"
            chart.data.datasets[1].borderColor = colors.prior;
            chart.data.datasets[0].borderColor = colors.current;
            chart.options.scales.x.ticks.color = colors.text;
            chart.update('active');
        });
    }
});

</script>

  @livewireScripts
  </body>

</html>
