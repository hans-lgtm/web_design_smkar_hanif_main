<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User; // Tambahkan ini

class UserOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();
        

        if (!$user) {
            return response()->json([
                'status' => 'Unauthorized',
                'message' => 'Please login first'
            ], 401);
        }
        
  
        if (!($user instanceof User)) {
            return response()->json([
                'status' => 'Forbidden',
                'message' => 'this acces for user onlyy.'
            ], 403);
        }
        
        return $next($request);
    }
}