<?php


namespace App\Actions;


use App\Exceptions\ActionException;
use Illuminate\Http\JsonResponse;

/**
 * Returns a json error msg
 * Class Error
 * @package App\Actions
 */
class Error
{
    /**
     * @param string|null $errorMsg
     * @param int $code
     * @param array $errorMsgs
     * @return JsonResponse
     * @throws ActionException
     */
    public static function execute(string $errorMsg = null, int $code = 400, array $errorMsgs = []): JsonResponse
    {
        $response = [
            'msg' => $errorMsg ?? 'Unsuccessful',
            'success' => false
        ];

        if (!empty($errorMsgs)) {
            $response['data'] = $errorMsgs;
        }

        if (!preg_match('/^4\d{2}$/', $code)) {
            throw new ActionException('Invalid HTTP response code provided');
        }

        return response()->json($response, $code);
    }
}
