<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
	'name' => 'Teste Coalize',
	'language' => 'pt-BR',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
		'response'=>[
			// Retornar somente JSON na aplicação.
			'format'=>\yii\web\Response::FORMAT_JSON
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            // 'cookieValidationKey' => 'wahFbtuZH3Aw__bI7817XE32WaGu7ovp',  // Comentar 'cookieValidationKey': Ativar modo API stateful.

			'enableCookieValidation' => false, // Desativar 'enableCookieValidation': Ativar modo API stateful.

			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			],

			'enableCsrfValidation'=> false, // Desabilitar CSRF para POST
        ],

		// Comentar 'cache': Ativar modo API stateful.
        // 'cache' => [
        //     'class' => 'yii\caching\FileCache',
        // ],

        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,


        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				[
					'class' => 'yii\rest\UrlRule',
					'controller' => ['user', 'cliente', 'produto', ],
					
					
					'extraPatterns' => [
						'GET cliente/<cliente_id:\d+>' => 'produtos-por-cliente',
						'POST cadastro' => 'cadastro-produto',
						'POST novo' => 'cadastro-cliente',
					], // Foi necessário criar duas rotas POST porque não foi possível sobre-escrever o CREATE do REST.
									
					
					'except' => ['delete','update',], // Não poderá deletar ou atualizar.
				],
            ],

			'as tokenAuth' => [
				'class' => 'app\filters\TokenAuth',
			],
			
		],
		
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
