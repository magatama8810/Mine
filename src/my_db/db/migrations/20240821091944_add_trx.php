<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddTrx extends AbstractMigration
{
    public function up()
    {
        // trx_usersテーブル

        $this->table('trx_users')
            ->addColumn('user_name', 'string', ['limit' => 20])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addTimestamps()
            ->addIndex(['user_name'], ['unique' => true])
            ->create();

        // trx_commentsテーブル

        $this->table('trx_comments')
            ->addColumn('user_id', 'integer', ['signed' => false])
            ->addColumn('text', 'string', ['limit' => 255])
            ->addTimestamps()
            ->addForeignKey('user_id', 'trx_users', 'id')
            ->create();

    }

    public function down()
    {
        // trx_commentsテーブル

        $this->table('trx_comments')->drop()->save();

        // trx_usersテーブル
        
        $this->table('trx_users')->drop()->save();
    }
}
