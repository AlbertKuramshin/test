<?php

namespace app\models;

use Yii;


class Tag extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'tag';
    }

   
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getArticles()
    {
        return $this->hasMany(Articles::className(),['id' => 'article_id'])->viaTable('article_id',['tag_id' => 'id']);
    }
}
