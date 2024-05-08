<?php


namespace App\Actions;


use App\Exceptions\ActionException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

/**
 * Class HandleException
 * @package App\Actions
 */
class HandleException
{
    /**
     * @param Exception $e
     * @param string|null $errorMsg
     * @param int $code
     * @return JsonResponse
     * @throws ActionException
     */
    public static function execute(Exception $e /*error instance*/, string $errorMsg = null, int $code = 400): JsonResponse
    {
        // if the error is an instance of Illuminate\Auth\Access\AuthorizationException
        // that means it's because the current user is not permitted to perform an action
        if ($e instanceof AuthorizationException) {
            return ErrorMsg::execute($errorMsg ?? 'Unauthorized', 401);
        } elseif ($e instanceof ActionException) {
            return ErrorMsg::execute($e->getMessage(), $e->getCode());
        }

        $errorMsg = $errorMsg ?? 'Something went wrong';
        $data = [];
        // it will attach the actual error in the response
        // actual error should be hidden from the users in production so that it doesn't expose
        // any system related information to the end user
        if (App::environment(['staging', 'local'])) {
            $data['file'] = $e->getFile();
            $data['line'] = $e->getLine();
            $data['actualError'] = $e->getMessage();
        }
        return Error::execute($errorMsg, $code, $data);
    }
}
