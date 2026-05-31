<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MobileCashierOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return $this->unauthorizedResponse();
        }

        $cashier = User::where('api_token', hash('sha256', $token))
            ->where('role', 'kasir')
            ->where('status', 'aktif')
            ->first();

        if (! $cashier) {
            return $this->unauthorizedResponse();
        }

        $request->attributes->set('mobile_cashier', $cashier);

        return $next($request);
    }

    private function unauthorizedResponse()
    {
        return response()->json([
            'success' => false,
            'message' => 'Sesi masuk berakhir. Silakan masuk kembali.',
        ], 401);
    }
}
