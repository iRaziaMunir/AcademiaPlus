<?php

namespace App\Http\Middleware;

use App\Models\ApiRequestLog;
use Closure;
use Illuminate\Http\Request;

class ApiRequestLogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd('I am from middleware');
        $saveApiRequestLog = ApiRequestLog::create(
        [
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('user_agent'),
            'request_method' =>$request->method(),
            'request_url' =>$request->url(),
            'request_body' =>$request->getContent(),
        ]);

        $request['api_request_log_id'] = $saveApiRequestLog->id;
        return $next($request);
    }

    public function terminate($request, $response)
    {
        ApiRequestLog::find($request->api_request_log_id)->update(
        [
            'response_status_code' => $request->getContent(),
            'response_body' => $request->getStatusCode(),
        ]);
    }
}
