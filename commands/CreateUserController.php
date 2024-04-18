<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;


class CreateUserController extends Controller
{
    public function actionIndex($nome, $email, $username, $senha)
    {
		// O comando será:
		// php yii create-user "Everlon Passos" "everlon@protonmail.com" "everlon.passos" "1234567890"
		
		// $name = $this->ansiFormat('Alex', Console::FG_YELLOW);
		// echo "Hello, my name is $name.";
		
		try {
			$user = new User();
			$user->nome = $nome;
			$user->email = $email;
			$user->username = $username;
			$user->setPassword($senha);
			$user->generateToken();
			$user->generateAuthKey();

	        if (!$user->save()):
				throw new \Exception("Falha ao salvar usuário: " . json_encode($user->errors));
			endif;

			return "Usuário criado com sucesso. Token: {$user->token}\n";

		} catch (\Exception $e) {
			echo "ERRO ao criar usuário: " . $e->getMessage() . "\n";
			return ExitCode::UNSPECIFIED_ERROR;
		}
    
	}
}
