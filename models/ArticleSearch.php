<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Article;


class ArticleSearch extends Article
{
    
    public function rules()
    {
        return [
            [['id', 'viewed', 'user_id', 'status', 'category'], 'integer'],
            [['title', 'description', 'content', 'date', 'image'], 'safe'],
        ];
    }

    
    public function scenarios()
    {
        
        return Model::scenarios();
    }

    
    public function search($params)
    {
        $query = Article::find();

        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
           
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'viewed' => $this->viewed,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
