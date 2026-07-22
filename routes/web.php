<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\CaseFileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CaseController as AdminCaseController;
use App\Http\Controllers\Admin\CaseFileController as AdminCaseFileController;
use App\Http\Controllers\Admin\MissionCodeController as AdminMissionCodeController;
use App\Http\Controllers\Admin\DirectorMessageController as AdminDirectorMessageController;

Route::middleware('guest.player')->group(function () {
    Route::get('/', fn () => redirect()->route('login'));

    Route::get('/login', [AuthController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'store'])
        ->name('login.store');

    Route::get('/activate/{account_code}', [ActivationController::class, 'create'])
        ->name('activation.create');

    Route::post('/activate/{account_code}', [ActivationController::class, 'store'])
        ->name('activation.store');
});

Route::middleware('auth.player')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/dashboard/redeem', [DashboardController::class, 'redeem'])
        ->name('mission.redeem');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::post('/logout', [AuthController::class, 'destroy'])
        ->name('logout');

    Route::resource('cases', CaseController::class)
        ->only([
            'index',
            'show',
        ])
        ->parameters([
            'cases' => 'code',
        ]);

    Route::get('/cases/{case}/files/{file}', [CaseFileController::class, 'show'])
        ->name('case-files.show');

    Route::get('/cases/{code}/reports', [CaseController::class, 'reports'])
        ->name('cases.reports');

    Route::get('/cases/{code}/evidence', [CaseController::class, 'evidence'])
        ->name('cases.evidence');

    Route::get('/cases/{code}/witnesses', [CaseController::class, 'witnesses'])
        ->name('cases.witnesses');

    Route::get('/cases/{code}/suspects', [CaseController::class, 'suspects'])
        ->name('cases.suspects');

    Route::get('/cases/{code}/documents', [CaseController::class, 'documents'])
        ->name('cases.documents');

    Route::get('/cases/{code}/timeline', [CaseController::class, 'timeline'])
        ->name('cases.timeline');

    Route::get('/cases/{code}/notes', [CaseController::class, 'notes'])
        ->name('cases.notes');

    Route::get('/cases/{code}/submit-report', [CaseController::class, 'submitReport'])
        ->name('cases.submit-report');

    Route::get('/messages', [MessageController::class, 'index'])
        ->name('messages.index');

    Route::get('/messages/{message}', [MessageController::class, 'show'])
        ->name('messages.show');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])
        ->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'store'])
        ->name('admin.login.store');

    Route::middleware('auth.admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('/logout', [AdminAuthController::class, 'destroy'])
            ->name('admin.logout');

        Route::get(
            '/mission-codes',
            [AdminMissionCodeController::class, 'index']
        )->name('admin.mission-codes.index');

        Route::post(
            '/mission-codes',
            [AdminMissionCodeController::class, 'store']
        )->name('admin.mission-codes.store');

        Route::get(
            '/mission-codes/export',
            [AdminMissionCodeController::class, 'export']
        )->name('admin.mission-codes.export');

        Route::delete(
            '/mission-codes/{missionCode}',
            [AdminMissionCodeController::class, 'destroy']
        )->name('admin.mission-codes.destroy');

        Route::resource('cases', AdminCaseController::class)
            ->names('admin.cases');

        Route::get(
            '/cases/{case}/files',
            [AdminCaseFileController::class, 'index']
        )->name('admin.case-files.index');

        Route::get(
            '/cases/{case}/files/create',
            [AdminCaseFileController::class, 'create']
        )->name('admin.case-files.create');

        Route::post(
            '/cases/{case}/files',
            [AdminCaseFileController::class, 'store']
        )->name('admin.case-files.store');

        Route::get(
            '/cases/{case}/files/{file}',
            [AdminCaseFileController::class, 'show']
        )->name('admin.case-files.show');

        Route::get(
            '/cases/{case}/files/{file}/edit',
            [AdminCaseFileController::class, 'edit']
        )->name('admin.case-files.edit');

        Route::put(
            '/cases/{case}/files/{file}',
            [AdminCaseFileController::class, 'update']
        )->name('admin.case-files.update');

        Route::delete(
            '/cases/{case}/files/{file}',
            [AdminCaseFileController::class, 'destroy']
        )->name('admin.case-files.destroy');

        Route::post(
            '/cases/{case}/files/reorder',
            [AdminCaseFileController::class, 'reorder']
        )->name('admin.case-files.reorder');

        Route::patch(
            '/cases/{case}/files/{file}/toggle-lock',
            [AdminCaseFileController::class, 'toggleLock']
        )->name('admin.case-files.toggle-lock');

        Route::resource('players', PlayerController::class)
            ->except(['show'])
            ->names('admin.players');

        Route::get('/players/{player}/assign-cases', [PlayerController::class, 'assignCases'])
            ->name('admin.players.assign-cases');

        Route::post('/players/{player}/assign-cases', [PlayerController::class, 'saveAssignedCases'])
            ->name('admin.players.assign-cases.save');

        Route::get('/messages/create', [AdminDirectorMessageController::class, 'create'])
            ->name('admin.messages.create');

        Route::post('/messages', [AdminDirectorMessageController::class, 'store'])
            ->name('admin.messages.store');
    });
});