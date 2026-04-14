<?php

use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\TicketPrintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::post('/webhooks/midtrans', MidtransWebhookController::class)
    ->name('webhooks.midtrans');

Route::middleware('auth')->group(function (): void {
    Route::get('/bookings/{booking}/ticket/print', TicketPrintController::class)
        ->name('tickets.print');
});
