<?php


namespace App\Actions;


use App\Exceptions\ActionException;
use Illuminate\Http\JsonResponse;

/**
 * Returns a success msg
 * Class SuccessMsg
 * @package App\Actions
 */
class SuccessMsg
{
    /**
     * @param string|null $msg
     * @param int $code
     * @return JsonResponse
     * @throws ActionException
     */
    public static function execute(string $msg = null, int $code = 200): JsonResponse
    {
        return Success::execute([], $msg, $code);
    }
}
