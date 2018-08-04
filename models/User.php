<?php

namespace app\models;
use yii\web\IdentityInterface;

use Yii;


class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
        ];
    }

    
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }

    
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        //return $this->auth_key;
    }

   
    public function validateAuthKey($authKey)
    {
        //return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($username)
    {
        return User::find()->where(['name' => $username])->one();
    }

    public function validatePassword($password)
    {
        return ($this->password == $password) ? true : false;
    }
}
