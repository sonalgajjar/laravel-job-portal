<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle incoming request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ❌ Agar admin login nahi hai
        if (!session()->has('admin_id')) {

            // 🔥 Optional: message ke sath redirect
            return redirect('/admin/login')
                ->with('error', 'Please login first');
        }

        // ✅ Agar login hai to aage jaane do
        return $next($request);
    }
}