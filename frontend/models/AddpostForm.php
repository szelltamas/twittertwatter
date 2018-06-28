<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use frontend\models\UploadForm;


class AddpostForm extends Model
{

    public $text;

    public function addpost(){

      $model = new UploadForm();

     $user = $model->getdata()[0]['id'];
     $update_time = date("Y-m-d");
     $conn = Yii::$app->db;
     $execute = $conn->createCommand("INSERT INTO post (user_id, text, update_time, megtekintes) VALUES ('$user', '$this->text', '$update_time', '0' )");
     $execute->query();
    }

    public function rules(){
        return [
            ['text', 'string', 'max'=> 160, 'min' => 10, 'tooShort'=> 'Legalább 10 karaktert kell írnod!', 'tooLong'=> 'Legfeljebb 160 karaktert írhatsz!' ],
            ['text', 'required', 'message' => 'A mező nem lehet üres.'],

        ];
    }

    public function attributeLabels()
{
    return [
        'text' => 'Szöveg',
    ];
}
}
