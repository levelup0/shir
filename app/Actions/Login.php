<?php


namespace App\Actions;


use App\Exceptions\ActionException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class Login
 * @package App\Actions
 */
class Login
{
    /**
     * @ $email
     * @param $email
     * @param $password
     * @return array
     * @throws ActionException
     */
    public static function execute($email, $password): array
    {
        $user = User::where('email', $email)
            ->first();

        if (!$user) {
            throw new ActionException('Email and password do not match');
        }

        $passwordMatched = Hash::check($password, $user->password);

        if (!$passwordMatched) {
            throw new ActionException('Password does not match');
        }

        $accessToken = $user->createToken('login');

        return [
            'user' => $user,
            'token' => $accessToken,
        ];
    }
}
