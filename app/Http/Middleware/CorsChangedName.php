<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request)
        //  ->header('Access-Control-Allow-origin',"*")
        //  ->header('Access-Control-Allow-Methods',"GET, POST, PUT, DELETE, PATCH, OPTIONS")
        //  ->header('Access-Control-Allow-Headers',"Origin, Content-Type, Accept, Authorization, X-Request-With");
        header("Access-Control-Allow-Origin: http://localhost:3000");
        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, PUT, OPTIONS, PATCH, DELETE',
            'Access-Control-Allow-hEADERS' => 'Origin, Content-Type, Accept, Authorization, X-Request-With, X-Auth-Token ',
        ];
        if($request->getMethod() == 'OPTIONS'){
            return response('OK')->withHeaders($headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value)
            $response->header($key, $value);
            return $response;
    }
}
