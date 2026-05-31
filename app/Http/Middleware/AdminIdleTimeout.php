<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminIdleTimeout
{
    private const TIMEOUT_SECONDS = 1800;

    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || (Auth::user()->role ?? null) !== 'admin') {
            return $next($request);
        }

        $now = time();
        $lastActivity = (int) $request->session()->get('admin_last_activity_at', $now);

        if (
            $request->session()->has('admin_last_activity_at')
            && ($now - $lastActivity) >= self::TIMEOUT_SECONDS
        ) {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi Anda berakhir karena tidak ada aktivitas selama 30 menit.',
                ], 401);
            }

            return redirect()->route('login')->with('idle_timeout', true);
        }

        $request->session()->put('admin_last_activity_at', $now);

        return $next($request);
    }
}
