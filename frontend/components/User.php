<?php
namespace frontend\components;

use Yii;

class User extends \yii\web\User
{
    public function getUsername()
    {
        return \Yii::$app->user->identity->username;
    }

    public function getEmail()
    {
        return \Yii::$app->user->identity->email;
    }

    public function getAvatar()
    {
        return \Yii::$app->user->identity->avatar;
    }
}
