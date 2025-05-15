<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CottageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Foundation\Application;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [AppointmentController::class,'create'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/apply-to-rent/create',[ApplicationController::class, 'create'])->name('application.create');


    Route::post('/appointments',[AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments',[AppointmentController::class, 'index'])->name('appointments.index');


    #Admin routes
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::put('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::get('tenants/appointments',[AppointmentController::class, 'allAppointments'])->name('all-appointments.index');


    # Rental Applications Routes
    Route::get('tenants/applications',[ApplicationController::class, 'index'])->name('applications.index');
    Route::get('tenants/applications/{application}',[ApplicationController::class, 'show'])->name('applications.show');



    // Route::get('tenant/appointments',[AppointmentController::class, 'allAppointments'])->name('all-appointments.index');

    Route::get('/apply-to-rent/create',[ApplicationController::class, 'create'])->name('application.create');
    Route::post('/apply-to-rent',[ApplicationController::class, 'store'])->name('application.store');
    Route::get('/notifications',[NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/admin/notifications/unread-count', function () {
        return response()->json([
            'count' => auth()->user()->unreadNotifications()->count()
        ]);
    });

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/admin/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('admin.notifications.read');
});


Route::get('/cottages', [CottageController::class, 'index'])->name('cottages.index');

require __DIR__.'/auth.php';


