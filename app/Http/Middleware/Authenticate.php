<?php

use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Firebase\JWT\JWT;
use App\Models\User;

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle(Request $request, Closure $next)
    {
        define("admin","administrator");
     $getHeaders = apache_request_headers ();
     $token = $getHeaders['Authorization'];
     $key = "papasopkdapsdkdilaisdhfadhsugadkpjhghjkaeghku345345868KJHFHFG*";

     $decoded = JWT::decode($token, $key, array('HS256'));

        //primero verificamos que tiene permisos con su id de usuario
     $permiso = User::where('email', $decoded)->get()->first();
        if($permiso->role == "administrator"){
            return $next($request, $permiso);
        }else{
            echo "No tienes permisos";
        abort(403, "No tiene permisos");
        }
    }
}

