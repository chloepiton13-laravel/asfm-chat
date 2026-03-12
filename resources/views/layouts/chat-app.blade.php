<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Integrated ASFM Real-time Chat Center</title>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- CDN SweetAlert2 -->
<script src="https://cdn.jsdelivr.net"></script>



@vite(['resources/css/app.css', 'resources/js/app.js'])

@livewireStyles

<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0fbd49",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                    },
                    fontFamily: {
                        "display": ["Public Sans"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<style type="text/tailwindcss">
        body { font-family: 'Public Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .tab-active {
            @apply text-primary border-b-2 border-primary;
        }
        .tab-inactive {
            @apply text-slate-500 hover:text-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50;
        }#emoji-toggle:checked ~ #emoji-picker {
            display: flex;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased overflow-hidden">
  <div class="flex h-screen w-full flex-col">

    <livewire:header />

    {{ $slot }}

  </div>

  @livewireScripts
</body>
</html>
