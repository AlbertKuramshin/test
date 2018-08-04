<?php

use yii\db\Migration;


class m180727_201329_create_category_table extends Migration
{
    
    public function up()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),

        ]);
    }

    
    public function down()
    {
        $this->dropTable('category');
    }
}
