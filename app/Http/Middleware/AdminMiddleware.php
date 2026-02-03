<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // Check if user has admin role
        $user = auth()->user();
        
        if (!$this->isAdmin($user)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
            }
            
            // Redirect non-admins to their appropriate dashboard
            if ($user->role === 'organizer') {
                return redirect()->route('organizer.dashboard')
                    ->with('error', 'You do not have permission to access the admin area.');
            }
            
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this area.');
        }

        // Check if admin account is suspended
        if ($user->status === 'suspended') {
            auth()->logout();
            
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your account has been suspended.'], 403);
            }
            
            return redirect()->route('login')
                ->with('error', 'Your admin account has been suspended. Please contact support.');
        }

        return $next($request);
    }

    /**
     * Check if user is an admin.
     */
    protected function isAdmin($user): bool
    {
        // Check role field
        if (in_array($user->role, ['admin', 'super_admin'])) {
            return true;
        }

        // Alternative: check is_admin field if you use that instead
        if (property_exists($user, 'is_admin') && $user->is_admin) {
            return true;
        }

        // Alternative: check email domain for admins
        // Uncomment if you want email-based admin detection
        // $adminEmails = ['admin@voteafrika.com', 'super@voteafrika.com'];
        // if (in_array($user->email, $adminEmails)) {
        //     return true;
        // }

        return false;
    }
}
