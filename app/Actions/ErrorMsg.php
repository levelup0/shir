<?php


namespace App\Actions;


use App\Exceptions\ActionException;
use Illuminate\Http\JsonResponse;

/**
 * Return a json error msg
 * Class ErrorMsg
 * @package App\Actions
 */
class ErrorMsg
{
    /**
     * @param string|null $msg
     * @param int $code
     * @return JsonResponse
     * @throws ActionException
     */
    public static function execute(string $msg = null, int $code = 400): JsonResponse
    {
        return Error::execute($msg, $code);
    }
}
