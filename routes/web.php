<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSessionController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FaqReorderController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\VideoTopicController;
use App\Http\Controllers\PublicFaqController;
use App\Http\Controllers\PublicVideoController;
use App\Http\Middleware\PreventAdminCache;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicFaqController::class, 'index'])->name('public.index');
Route::get('/faq/{faq:slug}', [PublicFaqController::class, 'show'])
    ->missing(fn () => response()->view('public.not-found', [], 404))
    ->name('public.faq.show');

Route::get('/video', [PublicVideoController::class, 'index'])->name('public.videos.index');
Route::get('/video/{video:slug}', [PublicVideoController::class, 'show'])
    ->missing(fn () => response()->view('public.not-found', [], 404))
    ->name('public.videos.show');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', [AdminSessionController::class, 'create'])->name('login');
        Route::post('/login', [AdminSessionController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', PreventAdminCache::class])->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
        Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
        Route::put('/faqs/reorder', FaqReorderController::class)->name('faqs.reorder');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('/faqs/{faq}', [FaqController::class, 'show'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.show');
        Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.edit');
        Route::put('/faqs/{faq}', [FaqController::class, 'update'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.update');
        Route::patch('/faqs/{faq}/status', [FaqController::class, 'toggle'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.status');
        Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->whereNumber('faq')->missing(fn () => to_route('admin.faqs.index')->with('error', 'FAQ tidak ditemukan. Daftar telah dimuat ulang.'))->name('faqs.destroy');
        Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
        Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
        Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
        Route::post('/videos/quick', [VideoController::class, 'quickStore'])->name('videos.quick');
        Route::patch('/videos/{video}/link', [VideoController::class, 'updateLink'])->whereNumber('video')->name('videos.link');
        Route::get('/videos/{video}/edit', [VideoController::class, 'edit'])->whereNumber('video')->name('videos.edit');
        Route::put('/videos/{video}', [VideoController::class, 'update'])->whereNumber('video')->name('videos.update');
        Route::patch('/videos/{video}/status', [VideoController::class, 'toggle'])->whereNumber('video')->name('videos.toggle');
        Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->whereNumber('video')->name('videos.destroy');
        Route::get('/topics', [VideoTopicController::class, 'index'])->name('topics.index');
        Route::post('/topics', [VideoTopicController::class, 'store'])->name('topics.store');
        Route::put('/topics/{topic}', [VideoTopicController::class, 'update'])->whereNumber('topic')->name('topics.update');
        Route::delete('/topics/{topic}', [VideoTopicController::class, 'destroy'])->whereNumber('topic')->name('topics.destroy');
        Route::post('/logout', [AdminSessionController::class, 'destroy'])->name('logout');
    });
});
