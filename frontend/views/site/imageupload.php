<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'A Twatter mindenek felett';
?>
<div class="site-profil">

    <div class="body-content">


        <p class="lead">Hello <?= \Yii::$app->user->username ?></p>
        <?php
        $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

          <?= $form->field($model, 'uploadimage')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Feltöltés', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>





    </div>

</div>
