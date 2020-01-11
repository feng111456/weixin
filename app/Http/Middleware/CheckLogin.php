<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
          
        $admin = session('admin');
        if(!session('admin')){
           echo "<script>alert('非法操作，请登录');location.href='/login/login'</script>";die;
        };
        return $next($request);
    }
}
