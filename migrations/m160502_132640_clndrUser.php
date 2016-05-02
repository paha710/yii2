<?php

use yii\db\Schema;
use yii\db\Migration;

class m160502_132640_clndrUser extends Migration
{


    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->execute("
CREATE TABLE IF NOT EXISTS `clndr_user`(
    `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `username` VARCHAR(128) NOT NULL COMMENT '',
  `name` VARCHAR(45) NOT NULL COMMENT '',
  `surname` VARCHAR(45) NOT NULL COMMENT '',
  `password` VARCHAR(255) NOT NULL COMMENT '',
  `salt` VARCHAR(255) NOT NULL COMMENT '',
  `access_token` VARCHAR(255) NULL DEFAULT NULL COMMENT '',
  `create_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `username_UNIQUE` (`username` ASC)  COMMENT '',
  UNIQUE INDEX `access_token_UNIQUE` (`access_token` ASC)  COMMENT '')
ENGINE = InnoDB");
    }

    public function safeDown()
    {
        $this->execute("
            DROP TABLE IF EXISTS `clndr_user`;
        ");
    }
    
}
