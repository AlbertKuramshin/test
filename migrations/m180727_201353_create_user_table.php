<?php

use yii\db\Migration;


class m180727_201353_create_user_table extends Migration
{
    
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(),
            'email'=>$this->string()->defaultValue(null),
            'password'=>$this->string(),
            'isAdmin'=>$this->integer()->defaultValue(0),
            'photo'=>$this->string()->defaultValue(null),
        ]);
    }

    
    public function down()
    {
        $this->dropTable('user');
    }
}
