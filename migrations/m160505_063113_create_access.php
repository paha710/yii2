<?php

use yii\db\Migration;

class m160505_063113_create_access extends Migration
{
    public function up()
    {
        $this->createTable('access',[
            'id'=>$this->primaryKey()->notNull(),
            'user_owner'=>$this->integer()->notNull(),
            'user_guest'=>$this->integer()->notNull(),
            'date'=>$this->dateTime()->notNull()
        ]);

    }

    public function down()
    {
        $this->dropTable('access');
    }
    public function safeUp()
    {
        $this->createTable('access',[
            'id'=>$this->primaryKey()->notNull(),
            'user_owner'=>$this->integer()->notNull(),
            'user_guest'=>$this->integer()->notNull(),
            'date'=>$this->dateTime()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('access');
    }
}
