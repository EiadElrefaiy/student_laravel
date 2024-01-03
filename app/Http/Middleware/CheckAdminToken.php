<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class CheckAdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($guard != null){
            auth()->shouldUse($guard); //shoud you user guard / table
            $token = $request->header('auth-token');
            $request->headers->set('auth-token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer '.$token, true);
            try
            {
              //  $user = $this->auth->authenticate($request);  //check authenticted user
              $user = JWTAuth::parseToken()->authenticate();
            }
          catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response() ->json(["status" => false , "msg" => "token not found"]) ;
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response() ->json(["status" => false , "msg" => "token not found"]) ;
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){
            return response() ->json(["status" => false , "msg" => "token not found"]) ;
        }
              }
         return $next($request);
    }
}
