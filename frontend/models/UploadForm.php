<?php
namespace frontend\models;

use Yii;
use yii\base\Model;


class UploadForm extends Model
{
   public $uploadimage;

   public function rules()
   {
     return [[['uploadimage'], 'file', 'extensions'=>'jpg, jpeg, gif, png', 'wrongExtension' => 'Csak jpg, gif és png tölthető fel!'],
   ];


   }

   public function attributeLabels()
{
   return [
       'uploadimage' => 'Képfeltöltés',
   ];
}

   public function update($image)
   {
     $user = Yii::$app->user->username;
    $conn = Yii::$app->db;
    $execute = $conn->createCommand("UPDATE user SET avatar = '$image' WHERE username = '$user' ");
    $execute->query();
   }


   public function getdata($nev = null)
   {
     if (empty($nev)) {$user = Yii::$app->user->username; }
     else {$user = $nev;}
     $conn = Yii::$app->db;
     $execute = $conn->createCommand("SELECT * FROM user WHERE username =  '$user'");
     return $execute->queryAll();
   }



}

?>
