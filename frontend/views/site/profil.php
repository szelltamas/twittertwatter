<?php
use frontend\models\UploadForm;
use yii\helpers\Html;
use frontend\models\AddpostForm;


$default = "frontend/web/profilimages/default.jpg";
$model = new UploadForm();


/* @var $this yii\web\View */

$this->title = 'A Twatter mindenek felett';
$user = $model->getdata()[0]['username'];
?>

<div class="site-profil">

    <div class="body-content">


        <p class="lead">Üdv, <?= \Yii::$app->user->username ?></p>


        <a href="index.php?r=site%2Fimageupload"><img src=" <?= $model->getdata()[0]['avatar'] ?> " style="width: 160px; height: 160px;" /></a>
        <br><br>
        <p class="text-align">A kép lecseréléséhez katt a képre!</p>
        <p class="text-align">Vagy <?= Html::a('Töröld', ['deleteimage'])?></p>


        <?php
        $con = \Yii:: $app->db;

        $sql = $con->createCommand("select post.id, user.username, user.avatar, post.text, post.update_time, post.megtekintes from post INNER JOIN user on post.user_id = user.id where user.username = '$user' order by post.id desc");

        $posts = $sql->query();


          foreach($posts as $post) {
            $date = strToTime($post['update_time']);

          ?>
          <p><?= Html::a('Posztok', ['myposts', 'nev'=>$post['username']])  ?></p>

        <?php }


        ?>

          </div>








        </div>




</div>
