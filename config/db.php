<?php

return [
    'class' => 'yii\db\Connection',
    // Para usar de fora do container como no comando de terminal para criar Usuário.
    // 'dsn' => 'mysql:host=localhost:3636;dbname=docker_db',
    'dsn' => 'mysql:host=mysql:3306;dbname=docker_db',
    'username' => 'root',
    'password' => 'segredo',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
