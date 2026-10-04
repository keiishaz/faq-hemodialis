<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalFaqs' => Faq::query()->count(),
            'activeFaqs' => Faq::query()->active()->count(),
            'inactiveFaqs' => Faq::query()->where('is_active', false)->count(),
            'recentFaqs' => Faq::query()->orderByDesc('updated_at')->orderByDesc('id')->limit(5)->get(),
        ]);
    }
}
