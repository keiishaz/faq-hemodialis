<?php

namespace App\Http\Controllers\Admin;

use App\FaqOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqReorderRequest;
use Illuminate\Http\JsonResponse;

class FaqReorderController extends Controller
{
    public function __invoke(FaqReorderRequest $request, FaqOrder $order): JsonResponse
    {
        $validated = $request->validated();
        $snapshot = $order->save($validated['ids'], $validated['snapshot']);

        return response()->json([
            'message' => 'Urutan FAQ tersimpan.',
            'snapshot' => $snapshot,
        ]);
    }
}
