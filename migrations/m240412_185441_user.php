<?php

use yii\db\Migration;

/**
 * Class m240412_185441_usuario
 */
class m240412_185441_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'token' => $this->string(32)->notNull()->unique(),
			'auth_key' => $this->string(32)->notNull()->unique(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
			'status' => $this->string(1)->notNull()->defaultValue('1'),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime(),
        ]);

        // Gera uma chave de 32 caracteres automaticamente
        $this->execute("ALTER TABLE {{%user}} ADD CONSTRAINT check_token_length CHECK (LENGTH(token) = 32)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

}