<?php

use yii\db\Schema;
use yii\db\Migration;

class m160510_085429_create_access extends Migration
{
    public function safeUp()
    {
        $this->createTable('access',[
            'id'=>$this->primaryKey()->notNull(),
            'user_owner'=>$this->integer()->notNull(),
            'user_guest'=>$this->integer()->notNull(),
            'date'=>$this->timestamp()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('access');
    }
}
