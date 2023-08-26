<?php

namespace App\Http\Middleware;

use App\Jobs\WriteRequestLogJob;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $input = $request->all();

        //记录请求信息
        $time = date('Y-m-d H:i:s');
        $requestData = [
            'method' => $request->method(),
            'path' => $request->path(),
            'ip' => $request->getClientIp(),
            'user_id' => 0,
            'response_time' => microtime(true) - START,
            'content' => json_encode($input, JSON_UNESCAPED_UNICODE),
            'created_at' => $time,
            'updated_at' => $time,
        ];

        dispatch(new WriteRequestLogJob($requestData));

        return $response;
    }
}
