<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\User;


class UserController extends ActiveController
{
	public $modelClass = 'app\models\User';
	
	
	public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');
		
        $user = User::findByUsername($username);

        if ($user !== null && $user->validatePassword($password)) {
			// Gera um novo token para o usuário
			$user->generateToken();
			$user->save();
			
            return ['token' => $user->token];
        }

        return ['error' => 'Credenciais inválidas', ];
    }
	
	
    public function actionLogout()
    {
        $token = Yii::$app->request->headers->get('Authorization');

        $user = User::findByToken($token);

        if ($user !== null) {
            $user->token = null;
            $user->save();

            return ['message' => 'Logout realizado com sucesso'];
        }

        return ['error' => 'Usuário não encontrado'];
    }
	
}
