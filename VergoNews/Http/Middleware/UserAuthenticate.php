<?php
namespace App\Modules\VergoNews\Http\Middleware;

use Closure;
use App\Modules\VergoBase\Http\Services\User as Service;
use Illuminate\Http\Request;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $service = new Service();
        if($service->authByToken($request->session()->get('token'))) {
            $request->setUserResolver(function() use ($service){ return $service->getModel();});
            return $next($request);
        }
        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}
