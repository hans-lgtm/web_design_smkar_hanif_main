<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Dev; 

class DevOnly
{
    public function handle(Request $request, Closure $next): Response
    {
       
        $user = $request->user();
        

        if (!$user) {
            return response()->json([
                'status' => 'Unauthorized',
                'message' => 'Please login first'
            ], 401);
        }
        

        if (!($user instanceof Dev)) {
            return response()->json([
                'status' => 'Forbidden',
                'message' => 'You are not developer.'
            ], 403);
        }
        
        return $next($request);
    }
}