<?php


namespace App\Actions;


use App\Exceptions\ActionException;
use Illuminate\Http\JsonResponse;

/**
 * Return success response
 * Class Success
 * @package App\Actions
 */
class Success
{
    /**
     * @param array $result
     * @param string|null $msg
     * @param int $code
     * @return JsonResponse
     * @throws ActionException
     */
    public static function execute(array $result = [], string $msg = null, int $code = 200): JsonResponse
    {
        if (!$msg) {
            $msg = 'Данные успешно добавлены!';
        }
        $response = [
            'success' => true,
            'msg' => $msg,
            'status' => $code
        ];

        if (!preg_match('/^2\d{2}$/', $code)) {
            throw new ActionException('Code has to be HTTP 200 something success code');
        }

        if (count($result)) {
            foreach ($result as $key => $value) {
                $response[$key] = $value;
            }
        }
        return response()->json($response, $code);
    }
}
