<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UploadedFile;


class ClienteController extends ActiveController
{
	public $modelClass = 'app\models\Cliente';
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['authenticator'] = [
			'class' => HttpBearerAuth::class,
		];
		
	   return $behaviors;
	}

	public function actions()
	{
		return ArrayHelper::merge(parent::actions(),
		[
			'index' => [
				'pagination' => [
					'pageSize' => 12,
				],
				'sort' => [
					'defaultOrder' => [
						'nome' => SORT_ASC,
					],
				],
			],
		]);
	}
	
	public function actionCadastroCliente()
	{
		$model = new $this->modelClass();
		$model->load(Yii::$app->getRequest()->getBodyParams(), '');
	
		$arquivo = UploadedFile::getInstanceByName('foto');
		
		if ($arquivo !== null):
			$arquivo->saveAs('/app/api/upload/clientes/' . $arquivo->name);
			$model->foto = $arquivo->name;
		endif;

	    if ( $model->save() ):
	        return $model;
		endif;

        return $model->getErrors();
	}
	
}
