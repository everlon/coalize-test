<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cliente}}`.
 * Comando usado no terminal para gerar o migration:
 * $ php yii migrate/create create_cliente_table --fields="id:primaryKey,nome:string:notNull,cpf:bigInteger:notNull:unique,email:string:notNull:unique,logradouro:string,num:integer,cep:integer,cidade:string,uf:string(2),complemento:string,foto:string,sexo:string(1)"
 * created_at e updated_at foi adicionado depois nesta function().
 */
class m240415_125531_create_cliente_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cliente}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'cpf' => $this->bigInteger()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'logradouro' => $this->string(),
            'num' => $this->integer(),
            'cep' => $this->integer(),
            'cidade' => $this->string(),
            'uf' => $this->string(2),
            'complemento' => $this->string(),
            'foto' => $this->string(),
            'sexo' => $this->string(1),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cliente}}');
    }
}
