<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UploadedFile;


class ProdutoController extends ActiveController
{
	public $modelClass = 'app\models\Produto';
	
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
	

	public function actionCadastroProduto()
	{
		$model = new $this->modelClass();
		$model->load(Yii::$app->getRequest()->getBodyParams(), '');

		$arquivo = UploadedFile::getInstanceByName('foto');
		
		if ($arquivo !== null):
			// EAP: Não tratei as imagens ou nome do arquivo,
			//      mas seria tratato aqui as dimensões, nome padrão e tudo mais.
			$arquivo->saveAs('/app/api/upload/produtos/' . $arquivo->name);
			$model->foto = $arquivo->name;
		endif;

	    if ( $model->save() ):
	        return $model;
		endif;

        return $model->getErrors();
	}
	
	
	/*
	// EAP: Não consegui sobrescrever a CREATE.
	public function actionCreate()
	{
		echo 'Aqui';
	}*/
	
	
	public function actionProdutosPorCliente($cliente_id)
	{
		return $this->modelClass::find()->where(['cliente_id' => $cliente_id])->all();
	}
}
