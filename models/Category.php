<?php

namespace app\models;

use Yii;
use app\models\Article;


class Category extends \yii\db\ActiveRecord
{
    

    public function getArticles()
    {
        return $this->hasMany(Article::className(),['category_id' => 'id']);
    }

    public static function tableName()
    {
        return 'category';
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

    public function getArticlesCount()
    {
        $count = $this->getArticles()->count();
        return $count;
    }

    public static function getAll()
    {
        $categories = Category::find()->all();
        return $categories;
    }
}
