<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_company}}`.
 */
class m230101_000003_create_user_company_relation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_company}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'company_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-user_company-user_id',
            '{{%user_company}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_company-company_id',
            '{{%user_company}}',
            'company_id',
            '{{%company}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-user_company-user_id',
            '{{%user_company}}',
            'user_id'
        );

        $this->createIndex(
            'idx-user_company-company_id',
            '{{%user_company}}',
            'company_id'
        );

        $this->createIndex(
            'idx-user_company-user_id-company_id',
            '{{%user_company}}',
            ['user_id', 'company_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_company-company_id', '{{%user_company}}');
        $this->dropForeignKey('fk-user_company-user_id', '{{%user_company}}');
        $this->dropTable('{{%user_company}}');
    }
}
