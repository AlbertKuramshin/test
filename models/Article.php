<?php

namespace app\models;
use app\models\Category;
use app\models\ArticleTag;
use app\models\Tag;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

use Yii;


class Article extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'article';
    }

    
    public function rules()
    {
        return [
            [['title'],'required'],
            [['title','description','content'],'string','max'=>255],
            [['date'],'date','format'=>'php:Y-m-d'],
            [['date'],'default','value'=>date('Y-m-d')],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category',
        ];
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()

    {

        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';

    }



    public function deleteImage()

    {

        $imageUploadModel = new ImageUpload();

        $imageUploadModel->deleteCurrentImage($this->image);

    }



    public function beforeDelete()

    {

        $this->deleteImage();

        return parent::beforeDelete(); 

    }

    public function getCategory(){
        return $this->hasOne(Category::className(),['id' => 'category_id']);
    }

    public function saveCategory($category_id)
    {

        $category = Category::findOne($category_id);
        if($category != null){
            $this->link('category', $category);
            return true;
        }

    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds,'id');
    }

    public function saveTags($tags)
    {

        ArticleTag::deleteAll(['article_id'=>$this->id]);
        if(is_array($tags)){
            foreach ($tags as $tag_id) {
                $tag_id = Tag::findOne($tag_id);
                $this->link('tags',$tag_id);
            }
        }
    }

    public static function getAll($pageSize = 2)
    {
        $query = Article::find();
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);
        $articles = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }

    public static function findArticlesByCategory($id, $pageSize = 2){
        $query = Article::find()->where(['category_id' => $id]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $articles = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }

    public static function getArticlesByTag($id,$pageSize = 2)
    {
        $article_tag = ArticleTag::find()->where(['tag_id' => $id])->all();
        
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
        return $data;
        
    }

    

    public static function getPopular()
    {
        $popular = Article::find()->orderBy('viewed desc')->limit(3)->all();
        return $popular;
    }

    public static function getRecent()
    {
        $recent = Article::find()->orderBy('date desc')->limit(4)->all();
        return $recent;
    }

    public function getDate()
    {
        //Yii::$app->formatter->locale = 'ru-RU';
        $date = Yii::$app->formatter->asDate($this->date);
        return $date;
    }


}
