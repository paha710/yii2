<?php

use yii\db\Schema;
use yii\db\Migration;

class m160507_162244_create_user extends Migration
{public function safeUp()
{
    $this->createTable('user', [
        'id'=>$this->primaryKey(),
        'username'=>$this->string(128)->notNull()->unique(),
        'name'=>$this->string(45)->notNull(),
        'surname'=>$this->string(45)->notNull(),
        'password'=>$this->string(255)->notNull(),
        'salt'=>$this->string(255)->notNull(),
        'access_token' => $this->string(255)->notNull()->unique(),
        'create_date' => $this->timestamp()->notNull()
    ]);
}

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
