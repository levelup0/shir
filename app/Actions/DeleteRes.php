<?php


namespace App\Actions;


use Illuminate\Http\JsonResponse;

/**
 * Return 204 response on delete method
 * Class DeleteRes
 * @package App\Actions
 */
class DeleteRes
{
    public static function execute(): JsonResponse
    {
        return response()->json(status: 204);
    }
}
