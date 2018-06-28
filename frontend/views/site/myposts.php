<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\models\AddpostForm;
use yii\widgets\LinkPager;
use frontend\models\UploadForm;

/* @var $this yii\web\View */

$this->title = 'Főoldal';
?>
<div class="site-index">
  <div class="jumbotron">



    </div>

    <div class="body-content">

      <?php
      $con = \Yii:: $app->db;

      $sql = $con->createCommand("select post.id, user.username, user.avatar, post.text, post.update_time, post.megtekintes from post INNER JOIN user on post.user_id = user.id where user.username = '$nev' order by post.id desc");

      $posts = $sql->query();



        foreach($posts as $post) {
          $date = strToTime($post['update_time']);

        ?>
        <hr>
        <p><?= Html::a($post['username'], ['general_profil', 'nev'=>$post['username']])  ?></p>

        <?= Html::a(Html::img($post['avatar'], ['width'=>40, 'height'=>40]), ['general_profil', 'nev'=>$post['username']])  ?>
        <h2>
          <?php echo nl2br($post['text']); ?>
        </h2>
        <p><?= Html::a(date("Y.m.d", $date), ['twatts', 'id'=>$post['id']])  ?></p>
        <p>Megtekintések száma: <?= $post['megtekintes']; ?></p>
        <p><?= Html::a('Törlés', ['deletepost', 'id'=>$post['id']])?></p>
      <?php }


      ?>
    </div>
</div>
