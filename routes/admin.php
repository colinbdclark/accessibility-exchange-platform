<?php

use App\Http\Controllers\AdminController;
use App\Http\Livewire\AdminEstimatesAndAgreements;

Route::controller(AdminController::class)->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::multilingual('/estimates-and-agreements', [AdminEstimatesAndAgreements::class, '__invoke'])
            ->middleware(['auth', 'admin'])
            ->name('estimates-and-agreements');
    });