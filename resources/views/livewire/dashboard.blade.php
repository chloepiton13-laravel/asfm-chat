<div>



  <!DOCTYPE html>

  <html class="dark" lang="fr"><head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>ASFM Administrative Dashboard Overview</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
  <script id="tailwind-config">
          tailwind.config = {
              darkMode: "class",
              theme: {
                  extend: {
                      colors: {
                          "primary": "#0fbd49",
                          "background-light": "#f6f8f6",
                          "background-dark": "#102216",
                          "surface-dark": "#1a2e21",
                          "border-dark": "#2d4a37"
                      },
                      fontFamily: {
                          "display": ["Lexend"]
                      },
                      borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                  },
              },
          }
      </script>
  </head>
  <body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <!-- Sidebar ASFM Admin 2026 -->
    <aside class="w-64 bg-surface-dark border-r border-border-dark flex flex-col hidden lg:flex h-screen sticky top-0 shadow-2xl">
        <!-- Header Logo -->
        <div class="p-6 flex items-center gap-3 border-b border-border-dark/30">
            <div class="bg-primary p-2 rounded-lg text-background-dark shadow-sm">
                <span class="material-symbols-outlined block text-2xl font-bold">database</span>
            </div>
            <h1 class="text-xl font-bold tracking-tight text-slate-100 uppercase italic">ASFM <span class="text-primary not-italic font-black">Admin</span></h1>
        </div>

        <!-- Navigation Scrollable -->
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto py-6 custom-scrollbar scroll-smooth">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-300 group',
                   'bg-primary text-background-dark font-bold shadow-lg shadow-primary/20' => request()->routeIs('dashboard'),
                   'text-slate-400 hover:bg-white/5 hover:text-slate-100' => !request()->routeIs('dashboard'),
               ])>
                <span class="material-symbols-outlined group-hover:scale-110 transition-transform">dashboard</span>
                <span>Vue d'ensemble</span>
            </a>

            <!-- Section Sportive -->
            <div class="pt-8 pb-2 px-3">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.25em]">Compétition & Effectif</p>
            </div>

            <!-- Inscrire un joueur (NOUVEAU) -->
            <a href="{{ route('players.create') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all',
                   'bg-primary text-background-dark font-bold' => request()->routeIs('players.create'),
                   'text-slate-400 hover:bg-white/5 hover:text-slate-100' => !request()->routeIs('players.create'),
               ])>
                <span class="material-symbols-outlined">person_add</span>
                <span>Nouvelle Inscription</span>
            </a>

            <a href="{{ route('players.index') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all',
                   'bg-primary text-background-dark font-bold' => request()->routeIs('players.index'),
                   'text-slate-400 hover:bg-white/5 hover:text-slate-100' => !request()->routeIs('players.index'),
               ])>
                <span class="material-symbols-outlined">groups</span>
                <span>Liste des Joueurs</span>
            </a>

            <a href="{{ route('players.cards') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all',
                   'bg-primary text-background-dark font-bold' => request()->routeIs('players.cards'),
                   'text-slate-400 hover:bg-white/5 hover:text-slate-100' => !request()->routeIs('players.cards'),
               ])>
                <span class="material-symbols-outlined">badge</span>
                <span>Cartes de Membre</span>
            </a>

            <!-- Section Matchs -->
            <div class="pt-8 pb-2 px-3 border-t border-border-dark/20 mt-6">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.25em]">Matchs</p>
            </div>

            <a href="{{ route('matches.index') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all',
                   'bg-primary text-background-dark font-bold' => request()->routeIs('matches.index'),
                   'text-slate-400 hover:bg-white/5 hover:text-slate-100' => !request()->routeIs('matches.index'),
               ])>
                <span class="material-symbols-outlined">calendar_month</span>
                <span>Calendrier</span>
            </a>

            <!-- Administration & Trésorerie -->
            <div class="pt-8 pb-2 px-3 border-t border-border-dark/20 mt-6">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.25em]">Administration</p>
            </div>

            <a href="{{ route('finance.index') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all',
                   'bg-primary text-background-dark font-bold' => request()->routeIs('finance.index'),
                   'text-slate-400 hover:bg-white/5 hover:text-slate-100' => !request()->routeIs('finance.index'),
               ])>
                <span class="material-symbols-outlined">payments</span>
                <span>Trésorerie</span>
            </a>

            <a href="{{ route('users.index') }}"
               @class([
                   'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all',
                   'bg-primary text-background-dark font-bold' => request()->routeIs('users.index'),
                   'text-slate-400 hover:bg-white/5 hover:text-slate-100' => !request()->routeIs('users.index'),
               ])>
                <span class="material-symbols-outlined">shield_person</span>
                <span>Utilisateurs</span>
            </a>
        </nav>

        <!-- Profile Footer -->
        <div class="p-4 border-t border-border-dark bg-black/20 backdrop-blur-md">
            <div class="flex items-center gap-3 p-2 rounded-xl bg-white/5 border border-white/5 shadow-inner">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full border-2 border-primary/50 overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com..." alt="Admin Avatar">
                    </div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-surface-dark rounded-full"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-100 truncate italic">Administrateur</p>
                    <p class="text-[10px] text-primary font-black uppercase tracking-tighter">Super Admin 2026</p>
                </div>
            </div>
        </div>
    </aside>


  <!-- Main Content -->
  <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
  <!-- Top Header -->
  <header class="h-16 border-b border-border-dark bg-background-dark/50 backdrop-blur-md flex items-center justify-between px-8 z-10">
  <div class="flex items-center flex-1 max-w-xl">
  <div class="relative w-full">
  <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-xl">search</span>
  <input class="w-full bg-surface-dark border-border-dark focus:ring-primary focus:border-primary rounded-lg pl-10 pr-4 py-2 text-sm text-slate-100 placeholder-slate-500" placeholder="Rechercher un joueur, un match..." type="text"/>
  </div>
  </div>
  <div class="flex items-center gap-4">
  <button class="relative p-2 text-slate-400 hover:text-primary transition-colors">
  <span class="material-symbols-outlined">notifications</span>
  <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
  </button>
  <div class="h-8 w-[1px] bg-border-dark mx-2"></div>
  <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-border-dark text-slate-100 hover:bg-white/5 transition-colors text-sm font-medium">
  <span class="material-symbols-outlined text-red-500">logout</span>
  <span>Logout</span>
  </button>
  </div>
  </header>
  <!-- Dashboard Content -->
  <div class="flex-1 overflow-y-auto p-8 space-y-8">
  <!-- Welcome Section -->
  <div>
  <h2 class="text-2xl font-bold text-slate-100">Bonjour, Admin ASFM</h2>
  <p class="text-slate-400">Voici l'état actuel de la Ligue Vétéran aujourd'hui.</p>
  </div>
  <!-- Stats Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
  <div class="bg-surface-dark p-6 rounded-xl border border-border-dark">
  <div class="flex items-center justify-between mb-4">
  <div class="p-2 bg-primary/10 rounded-lg text-primary">
  <span class="material-symbols-outlined">person</span>
  </div>
  <span class="text-primary text-xs font-bold bg-primary/20 px-2 py-1 rounded-full">+12%</span>
  </div>
  <p class="text-slate-400 text-sm font-medium">Total Joueurs</p>
  <h3 class="text-2xl font-bold text-slate-100 mt-1">1,240</h3>
  </div>
  <div class="bg-surface-dark p-6 rounded-xl border border-border-dark">
  <div class="flex items-center justify-between mb-4">
  <div class="p-2 bg-blue-500/10 rounded-lg text-blue-500">
  <span class="material-symbols-outlined">sports_soccer</span>
  </div>
  <span class="text-blue-500 text-xs font-bold bg-blue-500/20 px-2 py-1 rounded-full">+5%</span>
  </div>
  <p class="text-slate-400 text-sm font-medium">Matchs ce mois</p>
  <h3 class="text-2xl font-bold text-slate-100 mt-1">42</h3>
  </div>
  <div class="bg-surface-dark p-6 rounded-xl border-2 border-orange-500/50 shadow-lg shadow-orange-500/5">
  <div class="flex items-center justify-between mb-4">
  <div class="p-2 bg-orange-500/10 rounded-lg text-orange-500">
  <span class="material-symbols-outlined">pending_actions</span>
  </div>
  <span class="text-orange-500 text-xs font-bold bg-orange-500/20 px-2 py-1 rounded-full">Urgent</span>
  </div>
  <p class="text-slate-400 text-sm font-medium">Demandes d'adhésion</p>
  <h3 class="text-2xl font-bold text-slate-100 mt-1">15</h3>
  </div>
  <div class="bg-surface-dark p-6 rounded-xl border border-border-dark">
  <div class="flex items-center justify-between mb-4">
  <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-500">
  <span class="material-symbols-outlined">account_balance_wallet</span>
  </div>
  <span class="text-emerald-500 text-xs font-bold bg-emerald-500/20 px-2 py-1 rounded-full">+8%</span>
  </div>
  <p class="text-slate-400 text-sm font-medium">Recettes cotisations</p>
  <h3 class="text-2xl font-bold text-slate-100 mt-1">4,500€</h3>
  </div>
  </div>
  <!-- Main Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
  <!-- Recent Activity -->
  <div class="lg:col-span-2 space-y-6">
  <div class="flex items-center justify-between">
  <h3 class="text-lg font-bold text-slate-100 flex items-center gap-2">
  <span class="material-symbols-outlined text-primary">history</span>
                                  Activité Récente
                              </h3>
  <button class="text-sm text-primary hover:underline font-medium">Voir tout</button>
  </div>
  <div class="bg-surface-dark rounded-xl border border-border-dark overflow-hidden">
  <div class="divide-y divide-border-dark">
  <div class="p-4 flex items-center gap-4 hover:bg-white/5 transition-colors">
  <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
  <span class="material-symbols-outlined">person_add</span>
  </div>
  <div class="flex-1">
  <p class="text-sm text-slate-100"><span class="font-bold">Jean Dupont</span> s'est inscrit à la ligue.</p>
  <p class="text-xs text-slate-500">Il y a 2 minutes</p>
  </div>
  <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded border border-primary/20">Joueur</span>
  </div>
  <div class="p-4 flex items-center gap-4 hover:bg-white/5 transition-colors">
  <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-500 shrink-0">
  <span class="material-symbols-outlined">edit_note</span>
  </div>
  <div class="flex-1">
  <p class="text-sm text-slate-100">Score mis à jour: <span class="font-bold">Selection A (2) - (1) Selection B</span></p>
  <p class="text-xs text-slate-500">Il y a 45 minutes</p>
  </div>
  <span class="text-xs px-2 py-1 bg-blue-500/10 text-blue-500 rounded border border-blue-500/20">Match</span>
  </div>
  <div class="p-4 flex items-center gap-4 hover:bg-white/5 transition-colors">
  <div class="w-10 h-10 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-500 shrink-0">
  <span class="material-symbols-outlined">payments</span>
  </div>
  <div class="flex-1">
  <p class="text-sm text-slate-100">Paiement reçu de <span class="font-bold">Marc Lefebvre</span> (50€).</p>
  <p class="text-xs text-slate-500">Il y a 2 heures</p>
  </div>
  <span class="text-xs px-2 py-1 bg-emerald-500/10 text-emerald-500 rounded border border-emerald-500/20">Cotisation</span>
  </div>
  <div class="p-4 flex items-center gap-4 hover:bg-white/5 transition-colors">
  <div class="w-10 h-10 rounded-full bg-orange-500/20 flex items-center justify-center text-orange-500 shrink-0">
  <span class="material-symbols-outlined">warning</span>
  </div>
  <div class="flex-1">
  <p class="text-sm text-slate-100">Certificat médical expiré pour <span class="font-bold">Luc Martin</span>.</p>
  <p class="text-xs text-slate-500">Il y a 4 heures</p>
  </div>
  <span class="text-xs px-2 py-1 bg-orange-500/10 text-orange-500 rounded border border-orange-500/20">Alerte</span>
  </div>
  </div>
  </div>
  <!-- Quick Actions Section -->
  <div class="space-y-4">
  <h3 class="text-lg font-bold text-slate-100 flex items-center gap-2">
  <span class="material-symbols-outlined text-primary">bolt</span>
                                  Actions Rapides
                              </h3>
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
  <button class="flex flex-col items-center justify-center gap-2 p-6 rounded-xl border border-border-dark bg-surface-dark hover:border-primary transition-all group">
  <span class="material-symbols-outlined text-3xl text-slate-400 group-hover:text-primary">person_add</span>
  <span class="text-sm font-semibold text-slate-100">Nouvelle Inscription</span>
  </button>
  <button class="flex flex-col items-center justify-center gap-2 p-6 rounded-xl border border-border-dark bg-surface-dark hover:border-primary transition-all group">
  <span class="material-symbols-outlined text-3xl text-slate-400 group-hover:text-primary">scoreboard</span>
  <span class="text-sm font-semibold text-slate-100">Saisir Score Match</span>
  </button>
  <button class="flex flex-col items-center justify-center gap-2 p-6 rounded-xl border border-border-dark bg-surface-dark hover:border-primary transition-all group">
  <span class="material-symbols-outlined text-3xl text-slate-400 group-hover:text-primary">picture_as_pdf</span>
  <span class="text-sm font-semibold text-slate-100">Exporter Classement</span>
  </button>
  </div>
  </div>
  </div>
  <!-- Side Widgets: Pending Tasks -->
  <div class="space-y-6">
  <div class="bg-surface-dark rounded-xl border border-border-dark overflow-hidden h-full">
  <div class="p-5 border-b border-border-dark bg-white/5">
  <h3 class="text-lg font-bold text-slate-100 flex items-center gap-2">
  <span class="material-symbols-outlined text-orange-500">checklist</span>
                                      Tâches en attente
                                  </h3>
  </div>
  <div class="p-5 space-y-4">
  <div class="flex items-start gap-3 p-3 rounded-lg bg-orange-500/5 border border-orange-500/10 group cursor-pointer hover:bg-orange-500/10 transition-colors">
  <div class="mt-1">
  <input class="w-5 h-5 rounded border-orange-500/50 bg-transparent text-orange-500 focus:ring-orange-500 focus:ring-offset-surface-dark" type="checkbox"/>
  </div>
  <div class="flex-1">
  <p class="text-sm font-medium text-slate-100">Valider 5 certificats médicaux</p>
  <p class="text-xs text-orange-500/70">Urgent - Reçu ce matin</p>
  </div>
  </div>
  <div class="flex items-start gap-3 p-3 rounded-lg bg-white/5 border border-border-dark group cursor-pointer hover:bg-white/10 transition-colors">
  <div class="mt-1">
  <input class="w-5 h-5 rounded border-slate-600 bg-transparent text-primary focus:ring-primary focus:ring-offset-surface-dark" type="checkbox"/>
  </div>
  <div class="flex-1">
  <p class="text-sm font-medium text-slate-100">Générer le classement J12</p>
  <p class="text-xs text-slate-500">À faire avant lundi</p>
  </div>
  </div>
  <div class="flex items-start gap-3 p-3 rounded-lg bg-white/5 border border-border-dark group cursor-pointer hover:bg-white/10 transition-colors">
  <div class="mt-1">
  <input class="w-5 h-5 rounded border-slate-600 bg-transparent text-primary focus:ring-primary focus:ring-offset-surface-dark" type="checkbox"/>
  </div>
  <div class="flex-1">
  <p class="text-sm font-medium text-slate-100">Envoyer convocation Match Amical</p>
  <p class="text-xs text-slate-500">Prévu pour le 15/10</p>
  </div>
  </div>
  <div class="flex items-start gap-3 p-3 rounded-lg bg-white/5 border border-border-dark group cursor-pointer hover:bg-white/10 transition-colors">
  <div class="mt-1">
  <input class="w-5 h-5 rounded border-slate-600 bg-transparent text-primary focus:ring-primary focus:ring-offset-surface-dark" type="checkbox"/>
  </div>
  <div class="flex-1">
  <p class="text-sm font-medium text-slate-100">Mise à jour règlements ligue</p>
  <p class="text-xs text-slate-500">Réunion prévue demain</p>
  </div>
  </div>
  </div>
  <div class="p-5 border-t border-border-dark mt-4">
  <button class="w-full py-2 px-4 rounded-lg bg-white/5 hover:bg-white/10 text-slate-400 text-sm font-medium transition-colors flex items-center justify-center gap-2">
  <span class="material-symbols-outlined text-sm">add</span>
                                      Ajouter une tâche
                                  </button>
  </div>
  </div>
  <!-- System Status Micro Widget -->
  <div class="bg-primary/5 rounded-xl border border-primary/20 p-5">
  <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-3">État du Système</h4>
  <div class="flex items-center gap-2 mb-2">
  <span class="flex h-2 w-2 relative">
  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
  <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
  </span>
  <span class="text-sm text-slate-100">Base de données en ligne</span>
  </div>
  <p class="text-xs text-slate-500">Dernière sauvegarde: il y a 12 min</p>
  </div>
  </div>
  </div>
  </div>
  </main>
  </div>
  </body></html>






</div>
