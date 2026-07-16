<?php

use App\Http\Controllers\ActivationController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminCaseController;
use App\Http\Controllers\Admin\AdminCaseFileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDirectorMessageController;
use App\Http\Controllers\Admin\AdminMissionCodeController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminPlayerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\CaseFileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestigationBoardController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest.player')
    ->group(function () {
        Route::get('/', fn () => redirect()->route('login'));

        Route::get('/login', [AuthController::class, 'create'])->name('login');
        Route::post('/login', [AuthController::class, 'store'])->name('login.store');

        Route::get('/activate/{account_code}', [ActivationController::class, 'create'])
            ->name('activation.create');

        Route::post('/activate/{account_code}', [ActivationController::class, 'store'])
            ->name('activation.store');
    });

Route::middleware('auth.player')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/dashboard/redeem', [DashboardController::class, 'redeem'])
        ->name('mission.redeem');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::resource('cases', CaseController::class)
        ->only(['index', 'show'])
        ->parameters([
            'cases' => 'case',
        ]);

    Route::get('/cases/{case}/files/{file}', [CaseFileController::class, 'show'])
        ->name('case-files.show');

    Route::get('/cases/{case}/board', [InvestigationBoardController::class, 'show'])
        ->name('investigation-board.show');

    Route::post('/cases/{case}/board/pin/{file}', [InvestigationBoardController::class, 'pinEvidence'])
        ->name('investigation-board.pin');

    Route::delete('/cases/{case}/board/files/{file}', [InvestigationBoardController::class, 'unpinEvidence'])
        ->name('investigation-board.unpin');

    Route::patch('/cases/{case}/board/items/{item}/move', [InvestigationBoardController::class, 'moveItem'])
        ->name('investigation-board.move');

    Route::patch('/cases/{case}/board/items/{item}/resize', [InvestigationBoardController::class, 'resizeItem'])
        ->name('investigation-board.resize');

    Route::patch('/cases/{case}/board/items/{item}/front', [InvestigationBoardController::class, 'bringToFront'])
        ->name('investigation-board.bring-to-front');

    Route::post('/cases/{case}/board/autosave', [InvestigationBoardController::class, 'autosave'])
        ->name('investigation-board.autosave');

    Route::post('/cases/{case}/board/connections', [InvestigationBoardController::class, 'createConnection'])
        ->name('investigation-board.connections.store');

    Route::delete('/cases/{case}/board/connections/{connection}', [InvestigationBoardController::class, 'deleteConnection'])
        ->name('investigation-board.connections.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
        ->name('notifications.read-all');

    Route::get('/messages', [MessageController::class, 'index'])
        ->name('messages.index');

    Route::get('/messages/{message}', [MessageController::class, 'show'])
        ->name('messages.show');
});

Route::prefix('admin')
    ->middleware('guest.admin')
    ->group(function () {
        Route::get('/login', [AdminAuthController::class, 'create'])
            ->name('admin.login');

        Route::post('/login', [AdminAuthController::class, 'store'])
            ->name('admin.login.store');
    });

Route::prefix('admin')
    ->middleware('auth.admin')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('/logout', [AdminAuthController::class, 'destroy'])
            ->name('admin.logout');

        /*
        |--------------------------------------------------------------------------
        | Players
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'players',
            AdminPlayerController::class
        )->except([
            'show',
        ])->names('admin.players');

        Route::get(
            '/players/{player}/assign-cases',
            [AdminPlayerController::class, 'assignCases']
        )->name('admin.players.assign-cases');

        Route::post(
            '/players/{player}/assign-cases',
            [AdminPlayerController::class, 'saveAssignedCases']
        )->name('admin.players.assign-cases.save');

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/notifications',
            [AdminNotificationController::class, 'index']
        )->name('admin.notifications.index');

        Route::get(
            '/notifications/create',
            [AdminNotificationController::class, 'create']
        )->name('admin.notifications.create');

        Route::post(
            '/notifications',
            [AdminNotificationController::class, 'store']
        )->name('admin.notifications.store');

        Route::get(
            '/notifications/{notification}',
            [AdminNotificationController::class, 'show']
        )->name('admin.notifications.show');

        Route::delete(
            '/notifications/{notification}',
            [AdminNotificationController::class, 'destroy']
        )->name('admin.notifications.destroy');

        Route::post(
            '/notifications/broadcast',
            [AdminNotificationController::class, 'broadcast']
        )->name('admin.notifications.broadcast');

        Route::patch(
            '/notifications/{notification}/read',
            [AdminNotificationController::class, 'markAsRead']
        )->name('admin.notifications.read');

        Route::patch(
            '/notifications/read-all',
            [AdminNotificationController::class, 'markAllAsRead']
        )->name('admin.notifications.read-all');

        /*
        |--------------------------------------------------------------------------
        | Director Messages
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/messages/create',
            [AdminDirectorMessageController::class, 'create']
        )->name('admin.messages.create');

        Route::post(
            '/messages',
            [AdminDirectorMessageController::class, 'store']
        )->name('admin.messages.store');

        /*
        |--------------------------------------------------------------------------
        | Mission Codes
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'mission-codes',
            AdminMissionCodeController::class
        )->except([
            'show',
            'edit',
            'update',
        ])->names('admin.mission-codes');

        Route::get(
            '/mission-codes/export',
            [AdminMissionCodeController::class, 'export']
        )->name('admin.mission-codes.export');

        /*
        |--------------------------------------------------------------------------
        | Cases
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'cases',
            AdminCaseController::class
        )->names('admin.cases');

        /*
        |--------------------------------------------------------------------------
        | Case Files
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'cases.files',
            AdminCaseFileController::class
        )->except([
            'show',
        ])->names([
            'index' => 'admin.case-files.index',
            'create' => 'admin.case-files.create',
            'store' => 'admin.case-files.store',
            'edit' => 'admin.case-files.edit',
            'update' => 'admin.case-files.update',
            'destroy' => 'admin.case-files.destroy',
        ]);

        Route::post(
            '/cases/{case}/files/reorder',
            [AdminCaseFileController::class, 'reorder']
        )->name('admin.case-files.reorder');

        Route::patch(
            '/cases/{case}/files/{file}/toggle-lock',
            [AdminCaseFileController::class, 'toggleLock']
        )->name('admin.case-files.toggle-lock');

        /*
        |--------------------------------------------------------------------------
        | Activity Logs
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/activity-logs',
            [\App\Http\Controllers\Admin\ActivityLogController::class, 'index']
        )->name('admin.activity-logs.index');

        Route::get(
            '/activity-logs/{activityLog}',
            [\App\Http\Controllers\Admin\ActivityLogController::class, 'show']
        )->name('admin.activity-logs.show');

        Route::delete(
            '/activity-logs/{activityLog}',
            [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy']
        )->name('admin.activity-logs.destroy');

        Route::delete(
            '/activity-logs',
            [\App\Http\Controllers\Admin\ActivityLogController::class, 'clear']
        )->name('admin.activity-logs.clear');

        Route::get(
            '/activity-logs-export',
            [\App\Http\Controllers\Admin\ActivityLogController::class, 'export']
        )->name('admin.activity-logs.export');

        /*
        |--------------------------------------------------------------------------
        | Reports
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/reports',
            [\App\Http\Controllers\Admin\ReportController::class, 'index']
        )->name('admin.reports.index');

        Route::get(
            '/reports/statistics',
            [\App\Http\Controllers\Admin\ReportController::class, 'statistics']
        )->name('admin.reports.statistics');

        Route::get(
            '/reports/export/{type}',
            [\App\Http\Controllers\Admin\ReportController::class, 'export']
        )->name('admin.reports.export');

        /*
        |--------------------------------------------------------------------------
        | Settings
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/settings',
            [\App\Http\Controllers\Admin\SettingsController::class, 'index']
        )->name('admin.settings.index');

        Route::put(
            '/settings',
            [\App\Http\Controllers\Admin\SettingsController::class, 'update']
        )->name('admin.settings.update');
    });