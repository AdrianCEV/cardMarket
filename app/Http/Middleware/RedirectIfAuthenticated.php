<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Firebase\JWT\JWT;
use App\Models\User;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
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
        if($permiso->role != "administrator"){
            return $next($request, $permiso);
        }else{
            echo "No tienes permisos";
        abort(403, "No tiene permisos");
        }
    }
    }
