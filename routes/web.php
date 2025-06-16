<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CottageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantDashboardController;
use App\Http\Controllers\WebsiteController;
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
    Route::post('/appointments/{appointment}/revoke', [AppointmentController::class, 'revoke'])->name('appointments.revoke');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/applications/{application}',[ApplicationController::class, 'tenantApplication'])->name('tenant.applications');
    Route::post('/appointments/{appointment}/propose-time', [AppointmentController::class, 'proposeNewTime'])->name('appointments.propose-time');
    Route::post('/applications/{application}/accept-application', [ApplicationController::class, 'accept'])->name('accept.applications');
    Route::post('/applications/{application}/revoke-application', [ApplicationController::class, 'revoke'])->name('revoke.applications');
    Route::post('/applications/{application}/decline-application', [ApplicationController::class, 'decline'])->name('decline.applications');
    // applications routes
    Route::get('tenants/applications',[ApplicationController::class, 'allApplications'])->name('all-applications.index');




    # Rental Applications Routes
    Route::get('tenants/applications',[ApplicationController::class, 'index'])->name('applications.index');
    Route::get('tenants/applications/{application}',[ApplicationController::class, 'show'])->name('applications.show');
    Route::get('/tenant/dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');



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
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us.index');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/how-it-works', [WebsiteController::class, 'howItWorks'])->name('how-it-works');

require __DIR__.'/auth.php';


