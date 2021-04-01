<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckHandler
{
    const HANDLER_DEPARTMENT = 'Отдел информационных технологий';

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (empty($user)) {
            return response()->json([
                'success' => false,
                'message'=>'Вы не авторизованы'
            ]);
        }

        if ($user->department !== self::HANDLER_DEPARTMENT) {
            return response()->json([
                'success' => false,
                'message'=>'Вы не являетесь членом ИТ отдела'
            ]);
        }
//        $authorization = $request->header('authorization');

        return $next($request);
    }
}
