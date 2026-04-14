<?php

namespace App\Http\Controllers;

use App\Services\Payment\MidtransWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function __invoke(Request $request, MidtransWebhookService $midtransWebhookService): JsonResponse
    {
        $payment = $midtransWebhookService->handleNotification($request->all());

        return response()->json([
            'status' => 'ok',
            'payment_id' => $payment->id,
        ]);
    }
}
