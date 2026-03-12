<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Configuration de la page */
        @page { margin: 2cm; }
        body {
            font-family: 'Roboto', Arial, sans-serif;
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* En-tête */
        .header {
            border-bottom: 3px solid #1e40af;
            padding-bottom: 20px;
            margin-bottom: 30px;
            background-color: #f0f4f8;
        }
        .header-title {
            font-size: 32px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            margin: 0;
        }
        .header-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-top: 5px;
        }

        /* Titres de section */
        h2 {
            font-size: 18px;
            color: #1e293b;
            text-transform: uppercase;
            margin-top: 40px;
            margin-bottom: 20px;
            padding-left: 15px;
            border-left: 5px solid #2563eb;
            font-weight: 600;
        }

        /* Tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #2563eb;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 15px 10px;
            border-bottom: 3px solid #e2e8f0;
        }
        td {
            padding: 12px 10px;
            font-size: 12px;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
            color: #4b5563;
        }

        /* Classes utilitaires */
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .text-primary { color: #2563eb; }
        .bg-slate { background-color: #f1f5f9; }

        /* Zones spécifiques */
        .rank-badge {
            display: inline-block;
            width: 25px;
            height: 25px;
            line-height: 25px;
            background: #2563eb;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .relegation-row { background-color: #fef2f2; }
        .pts-cell { font-weight: bold; font-size: 14px; color: #1e293b; }

        /* Saut de page */
        .page-break { page-break-before: always; }

        /* Pied de page */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }

        /* Animation de survol */
        tr:hover {
            background-color: #f3f4f6;
            cursor: pointer;
        }

        /* Styles des logos */
        .team-logo {
            width: 30px;
            height: 30px;
            object-fit: contain;
            border-radius: 50%;
            margin-right: 8px;
        }
    </style>
</head>
<body>

    <!-- ENTÊTE -->
    <div class="header">
        <table style="border: none; margin: 0;">
            <tr>
                <td style="border: none; text-align: left; padding: 0;">
                    <h1 class="header-title">Rapport de Ligue ASFM</h1>
                    <p class="header-subtitle">Document officiel généré le {{ now()->format('d/m/Y à H:i') }}</p>
                </td>
                <td style="border: none; text-align: right; padding: 0; vertical-align: top;">
                    <div style="font-weight: bold; color: #2563eb;">SAISON 2023-2024</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- SECTION 1 : CLASSEMENT -->
    <h2>Classement Général</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 40px;">Pos</th>
                <th class="text-left">Équipe</th>
                <th>MJ</th>
                <th>G</th>
                <th>N</th>
                <th>P</th>
                <th>BP</th>
                <th>BC</th>
                <th>DB</th>
                <th class="bg-slate">PTS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($standings as $index => $team)
                @php
                    $rank = $index + 1;
                    $isRelegation = $rank > (count($standings) - 2);
                @endphp
                <tr class="{{ $isRelegation ? 'relegation-row' : '' }}">
                    <td><span class="rank-badge">{{ $rank }}</span></td>
                    <td class="text-left font-bold">
                        <!-- Affichage du logo de l'équipe -->
                        <img src="{{ $team->logo_url }}" alt="{{ $team->nom }} logo" class="team-logo">
                        {{ $team->nom }}
                        <span style="color: #94a3b8; font-weight: normal; font-size: 10px;">({{ $team->sigle }})</span>
                    </td>
                    <td>{{ $team->mj }}</td>
                    <td>{{ $team->g }}</td>
                    <td>{{ $team->n }}</td>
                    <td>{{ $team->p }}</td>
                    <td>{{ $team->bp }}</td>
                    <td>{{ $team->bc }}</td>
                    <td class="font-bold {{ $team->db > 0 ? 'text-primary' : '' }}">
                        {{ $team->db > 0 ? '+' : '' }}{{ $team->db }}
                    </td>
                    <td class="bg-slate pts-cell">{{ $team->pts }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- SAUT DE PAGE -->
    <div class="page-break"></div>

    <!-- SECTION 2 : BUTEURS -->
    <h2>Meilleurs Buteurs</h2>
    <table style="width: 80%; margin-left: 0;">
        <thead>
            <tr>
                <th style="width: 50px;">Rang</th>
                <th class="text-left">Joueur</th>
                <th class="text-left">Club</th>
                <th style="width: 80px;">Buts Marqués</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topScorers as $index => $player)
                <tr>
                    <td><strong>{{ $index + 1 }}</strong></td>
                    <td class="text-left font-bold">{{ $player->first_name }} {{ $player->last_name }}</td>
                    <td class="text-left" style="color: #64748b;">{{ $player->equipe->nom ?? 'N/A' }}</td>
                    <td class="pts-cell text-primary">{{ $player->goals_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- PIED DE PAGE -->
    <div class="footer">
        Association Sportive de Football Moderne - Page 1 sur 1
    </div>

</body>
</html>
