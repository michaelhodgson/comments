<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\User;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) 
        {
            if ($request->ajax()) 
            {
                return response('Unauthorized.', 401);
            } 
            else 
            {
                return redirect()->guest('auth/login');
            }
        }
        else if ( $request->is('admin/*') && $this->auth->user()->user_type != User::$userTypes['admin'] )
        {
            return redirect('/reseller');
        }
        else if ( $this->auth->user()->user_type == User::$userTypes['admin'] || ( $this->auth->user()->user_type == User::$userTypes['reseller'] && $this->auth->user()->status == User::$statuses['active'] ) )
        {
            return $next( $request );
        }
        else if ( $request->is('reseller/welcome') || $request->is('reseller/contact') )
        {
            return $next( $request );
        }


        return redirect('/reseller/welcome');
    }
}
