<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ], [
            'message.required' => 'Pesan chatbot tidak boleh kosong.',
            'message.string' => 'Pesan chatbot harus berupa teks.',
            'message.max' => 'Pesan chatbot maksimal 1000 karakter.',
        ]);

        $chatbotUrl = config('services.chatbot.url');

        if (!$chatbotUrl) {
            return response()->json([
                'success' => false,
                'message' => 'URL service chatbot belum dikonfigurasi.',
            ], 500);
        }

        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->asJson()
                ->post($chatbotUrl, [
                    'message' => $validated['message'],
                ]);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service chatbot sedang tidak dapat diakses.',
                    'status' => $response->status(),
                    'detail' => $response->json(),
                ], 502);
            }

            return response()->json($response->json(), $response->status());
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungi service chatbot.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}