<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class JwtAuth extends BaseMiddleware
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
        // 检查此次请求中是否带有 token，如果没有则抛出异常。
        $this->checkForToken($request);

        // 使用 try 包裹，以捕捉 token 过期所抛出的 TokenExpiredException  异常

        // 检测用户的登录状态，如果正常则通过
        if ($this->auth->parseToken()->authenticate()) {
            return $next($request);
        }

        throw new UnauthorizedHttpException('jwt-auth', '未登录');
    }
}
