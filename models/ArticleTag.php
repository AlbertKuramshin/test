<?php

namespace app\models;
use yii\data\Pagination;
use app\models\Article;

use Yii;


class ArticleTag extends \yii\db\ActiveRecord
{
    
    public static function tableName()
    {
        return 'article_tag';
    }

    
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id'], 'integer'],
        ];
    }

   
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'tag_id' => 'Tag ID',
        ];
    }

    public function getImage()

    {
        $article = new Article();
        return ($article->image) ? '/uploads/' . $article->image : '/no-image.png';

    }
     public static function getTags($id)
    {
        $article_tag = ArticleTag::find()->where(['article_id' => $id])->all();
        $tag_ids = [];
        foreach ($article_tag as $at) {
            $tag_ids[] = $at->tag_id;
        }
        $tags = Tag::find()->where(['in','id',$tag_ids])->all();
        return $tags;
    }

    public static function getArticlesByTag($id,$pageSize = 2)
    {
        $article_tag = ArticleTag::find()->where(['tag_id' => $id]);
        $article_ids = [];
        foreach ($article_tag as $at) {
            $article_ids[] = $at->article_id;
        }
        $query = Article::find()->where(['in','id',$article_ids]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $query;
        
    }
}
