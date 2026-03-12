<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Configuration de la page */
        @page { margin: 2cm; }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* En-tête */
        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            margin: 0;
        }
        .header-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }

        /* Titres de section */
        h2 {
            font-size: 16px;
            color: #1e293b;
            text-transform: uppercase;
            margin-top: 40px;
            margin-bottom: 15px;
            padding-left: 10px;
            border-left: 4px solid #3b82f6;
        }

        /* Tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 12px 8px;
            border-bottom: 2px solid #e2e8f0;
        }
        td {
            padding: 10px 8px;
            font-size: 11px;
            border-bottom: 1px solid #f1f5f9;
            text-align: center;
        }

        /* Classes utilitaires */
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .text-primary { color: #2563eb; }
        .bg-slate { background-color: #f1f5f9; }

        /* Zones spécifiques */
        .rank-badge {
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 20px;
            background: #f1f5f9;
            border-radius: 50%;
            font-weight: bold;
        }
        .relegation-row { background-color: #fef2f2; }
        .pts-cell { font-weight: bold; font-size: 13px; color: #1e293b; }

        /* Saut de page */
        .page-break { page-break-before: always; }
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
                    <div style="font-weight: bold; color: #3b82f6;">SAISON 2023-2024</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- SECTION 1 : CLASSEMENT -->
    <h2>Classement Général</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">Pos</th>
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
                        {{ $team->nom }}
                        <span style="color: #94a3b8; font-weight: normal; font-size: 9px;">({{ $team->sigle }})</span>
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
    <div style="position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 10px;">
        Association Sportive de Football Moderne - Page 1 sur 1
    </div>

</body>
</html>
