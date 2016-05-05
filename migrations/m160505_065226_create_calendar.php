<?php

use yii\db\Migration;

class m160505_065226_create_calendar extends Migration
{
    public function safeUp()
    {
        $this->createTable('calendar',[
            'id'=>$this->primaryKey()->notNull(),
            'text'=>$this->text()->notNull(),
            'creator'=>$this->integer()->notNull(),
            'date_event'=>$this->dateTime()->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('calendar');
    }
}

