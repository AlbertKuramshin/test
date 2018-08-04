<?php

use yii\db\Migration;


class m180727_201339_create_tag_table extends Migration
{
    
    public function up()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),

        ]);
    }

    
    public function down()
    {
        $this->dropTable('tag');
    }
}
