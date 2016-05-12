<?php

use yii\db\Migration;

class m160510_085932_create_calendar extends Migration
{
    public function safeUp()
    {
        $this->createTable('calendar',[
            'id'=>$this->primaryKey()->notNull(),
            'text'=>$this->text()->notNull(),
            'creator'=>$this->integer()->notNull(),
            'date_event'=>$this->timestamp()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('calendar');
    }
}
