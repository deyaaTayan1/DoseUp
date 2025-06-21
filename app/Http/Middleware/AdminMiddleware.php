<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {

        if( !$request->user() || $request->user()->role !== 'admin'  ){
            return response()->json([
                'message' => 'access denied . only admin allowed' 
            ] , 403);
        }

        return $next($request);
    }
}
