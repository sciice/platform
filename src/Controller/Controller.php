<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 下发JSON数据.
     *
     * @param string $message
     * @param int $code
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response(string $message, int $code = 200, array $headers = [])
    {
        return response()->json(['message' => $message], $code, $headers);
    }
}
