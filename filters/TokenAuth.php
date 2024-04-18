<?php

namespace app\filters;

use Yii;
use yii\filters\auth\AuthMethod;


class TokenAuth extends AuthMethod
{

    public function authenticate($user, $request, $response)
    {
        echo $token = $request->getHeaders()->get('Authorization');

        if ($token !== null) {
            $user = User::findByToken($token);
			
            if ($user !== null) {
                return $user;
            }
        }

        return null;
    }

}
