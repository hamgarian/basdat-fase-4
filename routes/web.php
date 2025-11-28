<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HazardReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard dengan semua fitur hazard reports
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Hazard Reports CRUD
    Route::post('/dashboard/hazard-reports', [DashboardController::class, 'storeReport'])->name('dashboard.reports.store');
    Route::put('/dashboard/hazard-reports/{hazardReport}', [DashboardController::class, 'updateReport'])->name('dashboard.reports.update');
    Route::delete('/dashboard/hazard-reports/{hazardReport}', [DashboardController::class, 'destroyReport'])->name('dashboard.reports.destroy');
    
    // Incidents CRUD
    Route::post('/dashboard/incidents', [DashboardController::class, 'storeIncident'])->name('dashboard.incidents.store');
    Route::put('/dashboard/incidents/{incident}', [DashboardController::class, 'updateIncident'])->name('dashboard.incidents.update');
    Route::delete('/dashboard/incidents/{incident}', [DashboardController::class, 'destroyIncident'])->name('dashboard.incidents.destroy');
    
    // Investigations CRUD
    Route::post('/dashboard/investigations', [DashboardController::class, 'storeInvestigation'])->name('dashboard.investigations.store');
    Route::put('/dashboard/investigations/{investigation}', [DashboardController::class, 'updateInvestigation'])->name('dashboard.investigations.update');
    Route::delete('/dashboard/investigations/{investigation}', [DashboardController::class, 'destroyInvestigation'])->name('dashboard.investigations.destroy');
    
    // Audits CRUD
    Route::post('/dashboard/audits', [DashboardController::class, 'storeAudit'])->name('dashboard.audits.store');
    Route::put('/dashboard/audits/{audit}', [DashboardController::class, 'updateAudit'])->name('dashboard.audits.update');
    Route::delete('/dashboard/audits/{audit}', [DashboardController::class, 'destroyAudit'])->name('dashboard.audits.destroy');
    
    // Temuan CRUD
    Route::post('/dashboard/temuan', [DashboardController::class, 'storeTemuan'])->name('dashboard.temuan.store');
    Route::put('/dashboard/temuan/{temuan}', [DashboardController::class, 'updateTemuan'])->name('dashboard.temuan.update');
    Route::delete('/dashboard/temuan/{temuan}', [DashboardController::class, 'destroyTemuan'])->name('dashboard.temuan.destroy');
    
    // Library Manuals CRUD
    Route::post('/dashboard/library-manuals', [DashboardController::class, 'storeLibraryManual'])->name('dashboard.library-manuals.store');
    Route::put('/dashboard/library-manuals/{libraryManual}', [DashboardController::class, 'updateLibraryManual'])->name('dashboard.library-manuals.update');
    Route::delete('/dashboard/library-manuals/{libraryManual}', [DashboardController::class, 'destroyLibraryManual'])->name('dashboard.library-manuals.destroy');
    
    // Penerbangan CRUD
    Route::post('/dashboard/penerbangan', [DashboardController::class, 'storePenerbangan'])->name('dashboard.penerbangan.store');
    Route::put('/dashboard/penerbangan/{penerbangan}', [DashboardController::class, 'updatePenerbangan'])->name('dashboard.penerbangan.update');
    Route::delete('/dashboard/penerbangan/{penerbangan}', [DashboardController::class, 'destroyPenerbangan'])->name('dashboard.penerbangan.destroy');
    
    // Flight Movements CRUD
    Route::post('/dashboard/flight-movements', [DashboardController::class, 'storeFlightMovement'])->name('dashboard.flight-movements.store');
    Route::put('/dashboard/flight-movements/{flightMovement}', [DashboardController::class, 'updateFlightMovement'])->name('dashboard.flight-movements.update');
    Route::delete('/dashboard/flight-movements/{flightMovement}', [DashboardController::class, 'destroyFlightMovement'])->name('dashboard.flight-movements.destroy');
    
    // Pesawat CRUD
    Route::post('/dashboard/pesawat', [DashboardController::class, 'storePesawat'])->name('dashboard.pesawat.store');
    Route::put('/dashboard/pesawat/{pesawat}', [DashboardController::class, 'updatePesawat'])->name('dashboard.pesawat.update');
    Route::delete('/dashboard/pesawat/{pesawat}', [DashboardController::class, 'destroyPesawat'])->name('dashboard.pesawat.destroy');
    
    // Pilots CRUD
    Route::post('/dashboard/pilots', [DashboardController::class, 'storePilot'])->name('dashboard.pilots.store');
    Route::put('/dashboard/pilots/{pilot}', [DashboardController::class, 'updatePilot'])->name('dashboard.pilots.update');
    Route::delete('/dashboard/pilots/{pilot}', [DashboardController::class, 'destroyPilot'])->name('dashboard.pilots.destroy');
    
    // Clients CRUD
    Route::post('/dashboard/clients', [DashboardController::class, 'storeClient'])->name('dashboard.clients.store');
    Route::put('/dashboard/clients/{client}', [DashboardController::class, 'updateClient'])->name('dashboard.clients.update');
    Route::delete('/dashboard/clients/{client}', [DashboardController::class, 'destroyClient'])->name('dashboard.clients.destroy');

    // JSON data for edit forms
    Route::get('/dashboard/{type}/{id}/edit-data', [DashboardController::class, 'getEditData'])->name('dashboard.edit-data');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
