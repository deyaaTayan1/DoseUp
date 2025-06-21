<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PharmacistMiddleware
{
  
    public function handle(Request $request, Closure $next): Response
    {
        // if(!$request->user()  || $request->user()->role !== 'pharmacist' ){
        //     return response()->json([
        //         'message' => 'access denied . only pharmacist allowed'
        //     ],403);
        // }


        return $next($request);

    }
}
