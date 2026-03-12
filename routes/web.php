<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Chat\ChatApp;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Members\{
  MemberCreate,
  MemberEdit,
  MemberList
};
use App\Livewire\Pages\{
    Home,
    VeteranPlayerManagementList,
    VeteranPlayerRegistrationCrudForm,
    VeteranPlayerMembershipIdCardPdf,
    AsfmPlayerDirectory,
    AsfmPlayerDirectoryTopStats,
    AsfmMatchFixturesResultsList,
    RecordMatchResultForm,
    MatchDetailsTeamLineups,
    AsfmFullLeagueStandings,
    AsfmFinancialManagementDashboard,
    RecordNewPaymentForm,
    OfficialAsfmPaymentReceiptPdf,
    AdminUserManagementList,
    RolesPermissionsInterface,
    AsfmSystemAuditLogsOverview,
    AsfmLeagueDashboardOverview,
    AsfmMatchCreate,
    AsfmMatchList,
    PlayerProfile,
    AsfmEquipeList,
    AsfmEquipeCreate,
    AsfmSeason,
    AsfmSelectionContributionHistory,
    AsfmEquipementIndex,
    UserProfile,
    EquipeListJoueurs,
    EquipeCreateJoueur

};
use App\Livewire\Contribution\{
  EquipesContributionsList,
  EquipesContributionsCreate,
  EquipesContributionsEdit
};


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Core App
    Route::get('/home', Home::class)->name('home.index');
    Route::get('/chat', ChatApp::class)->name('chat');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/contributions/equipes', EquipesContributionsList::class)
    ->name('contributions.equipes'); // Optionnel, selon votre sécurité
    Route::get('/create', EquipesContributionsCreate::class)->name('contributions.create');
    Route::get('/contributions/{contribution}/edit', EquipesContributionsEdit::class)
        ->name('contributions.edit');

    // --- ASFM ADMIN PANEL ---
    Route::prefix('admin')->group(function () {

        // Gestion Effectif
        Route::get('/joueurs', VeteranPlayerManagementList::class)->name('player.index');
        Route::get('/creat-joueurs', VeteranPlayerManagementList::class)->name('player.create');
        Route::get('/joueurs/inscription', VeteranPlayerRegistrationCrudForm::class)->name('players.create');
        Route::get('/joueurs/annuaire', AsfmPlayerDirectory::class)->name('players.directory');
        Route::get('/joueurs/top-stats', AsfmPlayerDirectoryTopStats::class)->name('players.top-stats');
        Route::get('/joueurs/cartes-membre', VeteranPlayerMembershipIdCardPdf::class)->name('players.cards');
        Route::get('/dashboard', AsfmLeagueDashboardOverview::class);
        Route::get('/asfm/equipes', AsfmEquipeList::class)->name('admin.equipes');
        Route::get('/admin/saisons', AsfmSeason::class)->name('seasons.index');
        Route::get('/profile', UserProfile::class)->name('profile.show');

        // Compétition
        Route::get('/matchs', AsfmMatchFixturesResultsList::class)->name('matche.index');
        Route::get('/admin/matchs/saisie-score/{id}', RecordMatchResultForm::class)
            ->name('matches.record-score');
        Route::get('/matchs/compositions', MatchDetailsTeamLineups::class)->name('matches.lineups');
        Route::get('/classements', AsfmFullLeagueStandings::class)->name('standings.index');
        Route::get('/admin/matchs/creer', AsfmMatchCreate::class)->name('matches.create');
        Route::get('/admin/matchs/list', AsfmMatchList::class)->name('matches.list');
        Route::get('/admin/joueurs/profil/{id}', PlayerProfile::class)->name('player.profile');
        Route::get('/admin/joueurs', VeteranPlayerManagementList::class)->name('admin.joueurs');
        Route::get('/equipes/creer', AsfmEquipeCreate::class)->name('equipes.create');
        Route::get('/admin/contributions/historique/{equipe}', AsfmSelectionContributionHistory::class)
            ->name('contributions.history');
        Route::get('/admin/members/create', MemberCreate::class)->name('admin.members.create');
        Route::get('/admin/members/{member}/edit', MemberEdit::class)->name('admin.members.edit');
        Route::get('/admin/members', MemberList::class)->name('admin.members');
        Route::get('/equipements', AsfmEquipementIndex::class)->name('equipements.index');
        Route::get('/equipes/{equipe}/joueurs', EquipeListJoueurs::class)->name('equipes.joueurs');
        Route::get('/admin/joueurs/{equipe}/nouveau', EquipeCreateJoueur::class)
            ->name('admin.players.create');

        // Finance
        Route::get('/finances', AsfmFinancialManagementDashboard::class)->name('finance.index');
        Route::get('/finances/paiement', RecordNewPaymentForm::class)->name('finance.record-payment');
        Route::get('/finances/reçus', OfficialAsfmPaymentReceiptPdf::class)->name('finance.receipts');

        // Système & Sécurité
        Route::get('/utilisateurs', AdminUserManagementList::class)->name('users.index');
        Route::get('/permissions', RolesPermissionsInterface::class)->name('system.permissions');
        Route::get('/logs', AsfmSystemAuditLogsOverview::class)->name('system.logs');
    });
});
