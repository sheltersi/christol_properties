<?php

use App\Console\Commands\AllocateOverpayment;
use App\Console\Commands\AllocatingOverPayments;
use App\Console\Commands\JustTestingScheduler;
use App\Models\Payment;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::call(new AllocateOverpayments)->daily();

Schedule::call(function () {
    Payment::delete();
})->daily();

Schedule::call(new AllocatingOverPayments)->everyTwoSeconds();
// Schedule::call(new JustTestingScheduler())->everyTwoSeconds();
