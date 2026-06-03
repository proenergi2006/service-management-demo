<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TrixAttachmentController;
use App\Http\Controllers\ProjectUpdateController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProjectBoardController;
use App\Http\Controllers\UserAccessManagementController;

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetAssignmentController;
use App\Http\Controllers\AssetMaintenanceController;

use App\Http\Controllers\AssetDocumentController;

use App\Http\Controllers\PublicAssetController;

use App\Http\Controllers\AssetDashboardController;

use App\Http\Controllers\AssetAuditController;
use App\Http\Controllers\AssetAuditScanController;
use App\Http\Controllers\MasterRoomController;
use App\Http\Controllers\RoomBookingController;
use App\Http\Controllers\MasterVehicleController;
use App\Http\Controllers\VehicleBookingController;
use App\Http\Controllers\GuestVisitController;
use App\Http\Controllers\AssetImportController;
use App\Http\Controllers\GaDashboardController;
use App\Http\Controllers\AssetWorkOrderController;
use App\Http\Controllers\AssetMaintenanceScheduleController;
use App\Http\Controllers\AssetWorkOrderChecklistController;
use App\Http\Controllers\AssetMeterReadingController;
use App\Http\Controllers\AssetWorkOrderSparepartController;
use App\Http\Controllers\AssetSparepartController;
use App\Http\Controllers\AssetSparepartMovementController;
use App\Http\Controllers\AssetMaintenanceVendorController;


// HALAMAN UTAMA diarahkan ke TicketController@index
Route::get('/', [TicketController::class, 'index'])->name('welcome');

// Simpan ticket baru
//Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

// Optional: API route untuk auto-refresh
Route::get('/api/tickets', [TicketController::class, 'apiList'])->name('tickets.api');

Route::post('/chat/ask', [TicketController::class, 'chatAsk'])->name('chat.ask');

Route::get('/asset-scan/{qr_code}', [PublicAssetController::class, 'show'])
    ->name('assets.scan.public');



// Route default bawaan Breeze (biarkan untuk dashboard login)

// Login pembeda tampilan
Route::get('/login/user', fn () => redirect()->route('login', ['type' => 'user']))->name('login.user');
Route::get('/login/it', fn () => redirect()->route('login', ['type' => 'it']))->name('login.it');

// Route::get('/dashboard', [TicketController::class, 'dashboard'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::patch('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
//     Route::get('/trend', [TrendController::class, 'index'])->name('trend');
//     Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
//     Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
//     Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.export.pdf');
//     Route::patch('/tickets/{id}/priority', [TicketController::class, 'updatePriority'])
//         ->name('tickets.updatePriority');
//     Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
//     Route::get('/tickets/{id}/detail', [TicketController::class, 'detail']);
//     Route::put('/tickets/{id}/transfer', [TicketController::class, 'transfer'])
//         ->name('tickets.transfer');
//         Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
//         ->name('documents.download');

//     Route::resource('documents', DocumentController::class)->except(['show']);
//     Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])
//     ->name('documents.preview');
   
//     Route::middleware('auth')->post('/trix/upload', [TrixAttachmentController::class, 'store'])
//     ->name('trix.upload');

//      // progress / comment updates
//      Route::post('projects/{project}/updates', [ProjectUpdateController::class, 'store'])->name('projects.updates.store');
//      Route::delete('projects/{project}/updates/{update}', [ProjectUpdateController::class, 'destroy'])->name('projects.updates.destroy');
 
//      // trix upload (image/pdf/excel)
//      Route::post('/trix/upload', [TrixAttachmentController::class, 'store'])->name('trix.upload');

//      Route::get('/projects/board', [ProjectBoardController::class, 'index'])->name('projects.board');
//      Route::post('/projects/board/move', [ProjectBoardController::class, 'move'])->name('projects.board.move');
//      Route::post('/projects/board/quick-add', [ProjectBoardController::class, 'quickAdd'])
//     ->name('projects.board.quickAdd');

//      Route::resource('projects', ProjectController::class);

//      Route::resource('meetings', MeetingController::class);


//      Route::get('meetings/{meeting}/export-pdf', [MeetingController::class, 'exportPdf'])
//     ->name('meetings.export.pdf');

   
Route::get('/guest/check-in', [GuestVisitController::class, 'publicForm'])
    ->name('guest.check-in');

Route::post('/guest/check-in', [GuestVisitController::class, 'storePublic'])
    ->name('guest.check-in.store');

Route::get('/guest/thank-you', [GuestVisitController::class, 'thankYou'])
    ->name('guest.thank-you');


    

// });

// Semua user yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/my-tickets', [TicketController::class, 'myTickets'])->name('tickets.my');
    Route::get('/my-tickets/{id}', [TicketController::class, 'myTicketDetail'])->name('tickets.my.detail');
    Route::post('/my-tickets/{id}/feedback', [TicketController::class, 'submitFeedback'])->name('tickets.my.feedback');

    Route::get('/my-tickets/{id}/edit', [TicketController::class, 'editMyTicket'])->name('tickets.my.edit');
    Route::put('/my-tickets/{id}', [TicketController::class, 'updateMyTicket'])->name('tickets.my.update');

    Route::get('/dashboard', [TicketController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/facility/room-bookings/my', [RoomBookingController::class, 'myBookings'])
    ->name('room-bookings.my');

Route::get('/facility/vehicle-bookings/my', [VehicleBookingController::class, 'myBookings'])
    ->name('vehicle-bookings.my');

Route::resource('/facility/room-bookings', RoomBookingController::class)
    ->names('room-bookings');

Route::resource('/facility/vehicle-bookings', VehicleBookingController::class)
    ->names('vehicle-bookings');

    Route::patch('/vehicle-bookings/{vehicleBooking}/cancel', [VehicleBookingController::class, 'cancel'])
    ->name('vehicle-bookings.cancel');

    Route::get('/export/template/{type}', [AssetImportController::class, 'downloadTemplate'])
    ->name('assets.template');

Route::post('/import', [AssetImportController::class, 'import'])
    ->name('assets.import');
});

// Khusus IT
Route::middleware(['auth', 'role:it'])->group(function () {
    Route::patch('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::patch('/tickets/{id}/priority', [TicketController::class, 'updatePriority'])->name('tickets.updatePriority');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/tickets/{id}/detail', [TicketController::class, 'detail']);
    Route::put('/tickets/{id}/transfer', [TicketController::class, 'transfer'])->name('tickets.transfer');

    Route::get('/trend', [TrendController::class, 'index'])->name('trend');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.export.pdf');

    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])->name('documents.preview');
    Route::resource('documents', DocumentController::class)->except(['show']);

    Route::post('/trix/upload', [TrixAttachmentController::class, 'store'])->name('trix.upload');

    Route::post('projects/{project}/updates', [ProjectUpdateController::class, 'store'])->name('projects.updates.store');
    Route::delete('projects/{project}/updates/{update}', [ProjectUpdateController::class, 'destroy'])->name('projects.updates.destroy');

    Route::get('/projects/board', [ProjectBoardController::class, 'index'])->name('projects.board');
    Route::post('/projects/board/move', [ProjectBoardController::class, 'move'])->name('projects.board.move');
    Route::post('/projects/board/quick-add', [ProjectBoardController::class, 'quickAdd'])->name('projects.board.quickAdd');

    Route::resource('projects', ProjectController::class);
    Route::resource('meetings', MeetingController::class);
    Route::get('meetings/{meeting}/export-pdf', [MeetingController::class, 'exportPdf'])->name('meetings.export.pdf');

    Route::resource('user-access-management', UserAccessManagementController::class)
        ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        Route::get('/reports/feedback', [ReportController::class, 'feedbackReport'])->name('reports.feedback');
        Route::get('/reports/sla', [ReportController::class, 'slaReport'])->name('reports.sla');

        Route::get('/user-access-management/export/excel', [UserAccessManagementController::class, 'exportExcel'])
    ->name('user-access-management.export.excel');

Route::get('/user-access-management/export/pdf', [UserAccessManagementController::class, 'exportPdf'])
    ->name('user-access-management.export.pdf');



  /*
|--------------------------------------------------------------------------
| ASSET WORK ORDERS
|--------------------------------------------------------------------------
*/


});

Route::middleware(['auth', 'role:it,IT,ga,GA,logistik,LOGISTIK'])->group(function () {

    Route::prefix('assets/work-orders')->name('assets.work-orders.')->group(function () {
        Route::get('/', [AssetWorkOrderController::class, 'index'])->name('index');
        Route::get('/create', [AssetWorkOrderController::class, 'create'])->name('create');
        Route::post('/', [AssetWorkOrderController::class, 'store'])->name('store');

        Route::get('/{workOrder}/export-pdf', [AssetWorkOrderController::class, 'exportPdf'])->name('export-pdf');

        Route::get('/{workOrder}', [AssetWorkOrderController::class, 'show'])->name('show');
        Route::get('/{workOrder}/edit', [AssetWorkOrderController::class, 'edit'])->name('edit');
        Route::put('/{workOrder}', [AssetWorkOrderController::class, 'update'])->name('update');

        Route::patch('/{workOrder}/submit', [AssetWorkOrderController::class, 'submit'])->name('submit');
        Route::patch('/{workOrder}/approve', [AssetWorkOrderController::class, 'approve'])->name('approve');
        Route::patch('/{workOrder}/reject', [AssetWorkOrderController::class, 'reject'])->name('reject');
        Route::patch('/{workOrder}/start', [AssetWorkOrderController::class, 'start'])->name('start');
        Route::patch('/{workOrder}/complete', [AssetWorkOrderController::class, 'complete'])->name('complete');

        Route::post('/{workOrder}/checklist-template', [AssetWorkOrderChecklistController::class, 'attachTemplate'])
            ->name('checklist.attach-template');

        Route::delete('/{workOrder}', [AssetWorkOrderController::class, 'destroy'])->name('destroy');
    });

    Route::put('/assets/work-order-checklist-items/{item}', [AssetWorkOrderChecklistController::class, 'updateItem'])
        ->name('assets.work-orders.checklist-items.update');

    Route::post('/assets/work-orders/{workOrder}/spareparts', [AssetWorkOrderSparepartController::class, 'store'])
        ->name('assets.work-orders.spareparts.store');

    Route::delete('/assets/work-orders/{workOrder}/spareparts/{sparepart}', [AssetWorkOrderSparepartController::class, 'destroy'])
        ->name('assets.work-orders.spareparts.destroy');

    Route::post('/assets/schedules/{schedule}/generate-work-order', [AssetMaintenanceScheduleController::class, 'generateWorkOrder'])
        ->name('assets.schedules.generate-work-order');

    Route::resource('assets/schedules', AssetMaintenanceScheduleController::class)
        ->names('assets.schedules');

    Route::post('/assets/{asset}/meter-readings', [AssetMeterReadingController::class, 'store'])
        ->name('assets.meter-readings.store');

    Route::resource('assets/spareparts', AssetSparepartController::class)
        ->names('assets.spareparts');

    Route::post('/assets/spareparts/{sparepart}/movements', [AssetSparepartMovementController::class, 'store'])
        ->name('assets.spareparts.movements.store');

    Route::resource('assets/vendors', AssetMaintenanceVendorController::class)
        ->names('assets.vendors');

    Route::get('/assets/reports/maintenance-cost', [AssetDashboardController::class, 'maintenanceCostReport'])
        ->name('assets.reports.maintenance-cost');

    Route::get('/assets/reports/reliability', [AssetDashboardController::class, 'reliability'])
        ->name('assets.reports.reliability');

    Route::get('/asset-dashboard', [AssetDashboardController::class, 'index'])
        ->name('assets.dashboard');

    Route::get('/assets-export', [AssetController::class, 'export'])
        ->name('assets.export');

    Route::get('/assets/print/bulk-qr', [AssetController::class, 'bulkQrPrint'])
        ->name('assets.bulk-qr-print');

    Route::get('/assets/{asset}/qr', [AssetController::class, 'qr'])
        ->name('assets.qr');

    Route::get('/assets/{asset}/qr-sticker', [AssetController::class, 'qrSticker'])
        ->name('assets.qr-sticker');

    Route::resource('assets', AssetController::class);

    Route::post('/assets/{asset}/assign', [AssetAssignmentController::class, 'store'])
        ->name('assets.assignments.store');

    Route::post('/assets/{asset}/return', [AssetAssignmentController::class, 'returnAsset'])
        ->name('assets.assignments.return');

    Route::post('/assets/{asset}/maintenances', [AssetMaintenanceController::class, 'store'])
        ->name('assets.maintenances.store');

    Route::put('/assets/{asset}/maintenances/{maintenance}', [AssetMaintenanceController::class, 'update'])
        ->name('assets.maintenances.update');

    Route::delete('/assets/{asset}/maintenances/{maintenance}', [AssetMaintenanceController::class, 'destroy'])
        ->name('assets.maintenances.destroy');

    Route::post('/assets/{asset}/documents', [AssetDocumentController::class, 'store'])
        ->name('assets.documents.store');

    Route::delete('/assets/{asset}/documents/{document}', [AssetDocumentController::class, 'destroy'])
        ->name('assets.documents.destroy');

    Route::get('/asset-audits', [AssetAuditController::class, 'index'])
        ->name('assets.audits.index');

    Route::get('/asset-audits/create', [AssetAuditController::class, 'create'])
        ->name('assets.audits.create');

    Route::post('/asset-audits', [AssetAuditController::class, 'store'])
        ->name('assets.audits.store');

    Route::get('/asset-audits/{audit}', [AssetAuditController::class, 'show'])
        ->name('assets.audits.show');

    Route::put('/asset-audits/{audit}/items/{item}', [AssetAuditController::class, 'updateItem'])
        ->name('assets.audits.items.update');

    Route::get('/asset-audits/{audit}/scan', [AssetAuditScanController::class, 'create'])
        ->name('assets.audits.scan');

    Route::post('/asset-audits/{audit}/scan', [AssetAuditScanController::class, 'store'])
        ->name('assets.audits.scan.store');
});


Route::middleware(['auth', 'role:ga,GA'])->group(function () {
    Route::resource('/facility/master-rooms', MasterRoomController::class)->names('master-rooms');
    Route::resource('/facility/master-vehicles', MasterVehicleController::class)->names('master-vehicles');

    Route::patch('/facility/room-bookings/{room_booking}/approve', [RoomBookingController::class, 'approve'])->name('room-bookings.approve');
    Route::patch('/facility/room-bookings/{room_booking}/reject', [RoomBookingController::class, 'reject'])->name('room-bookings.reject');

    Route::patch('/facility/vehicle-bookings/{vehicle_booking}/approve', [VehicleBookingController::class, 'approve'])->name('vehicle-bookings.approve');
    Route::patch('/facility/vehicle-bookings/{vehicle_booking}/reject', [VehicleBookingController::class, 'reject'])->name('vehicle-bookings.reject');

    Route::patch('/facility/vehicle-bookings/{vehicle_booking}/start-trip', [VehicleBookingController::class, 'startTrip'])->name('vehicle-bookings.start-trip');
    Route::patch('/facility/vehicle-bookings/{vehicle_booking}/return-trip', [VehicleBookingController::class, 'returnTrip'])->name('vehicle-bookings.return-trip');

    Route::get('/facility/guests', [GuestVisitController::class, 'index'])->name('guests.index');
    Route::patch('/facility/guests/{guest}/checkout', [GuestVisitController::class, 'checkout'])->name('guests.checkout');

    Route::get('/ga-dashboard', [GaDashboardController::class, 'index'])->name('ga.dashboard');
});

require __DIR__ . '/auth.php';
