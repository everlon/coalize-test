<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%produto}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%cliente}}`
 */
class m240417_132349_create_produto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%produto}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'preco' => $this->integer(),
            'cliente_id' => $this->integer()->notNull(),
            'foto' => $this->string(),
        ]);

        // creates index for column `cliente_id`
        $this->createIndex(
            '{{%idx-produto-cliente_id}}',
            '{{%produto}}',
            'cliente_id'
        );

        // add foreign key for table `{{%cliente}}`
        $this->addForeignKey(
            '{{%fk-produto-cliente_id}}',
            '{{%produto}}',
            'cliente_id',
            '{{%cliente}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%cliente}}`
        $this->dropForeignKey(
            '{{%fk-produto-cliente_id}}',
            '{{%produto}}'
        );

        // drops index for column `cliente_id`
        $this->dropIndex(
            '{{%idx-produto-cliente_id}}',
            '{{%produto}}'
        );

        $this->dropTable('{{%produto}}');
    }
}
