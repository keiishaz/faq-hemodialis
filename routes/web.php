<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSessionController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqReorderController;
use App\Http\Middleware\PreventAdminCache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminSessionController::class, 'create'])->name('login');
        Route::post('/login', [AdminSessionController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', PreventAdminCache::class])->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
        Route::put('/faqs/reorder', FaqReorderController::class)->name('faqs.reorder');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}', [FaqController::class, 'show'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.show');
        Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.edit');
        Route::put('/faqs/{faq}', [FaqController::class, 'update'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.update');
        Route::patch('/faqs/{faq}/status', [FaqController::class, 'toggle'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.status');
        Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.destroy');
        Route::post('/logout', [AdminSessionController::class, 'destroy'])->name('logout');
    });
});
