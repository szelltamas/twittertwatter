
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\models\AddpostForm;
/* @var $this yii\web\View */

$this->title = 'A Twatter mindenek felett';
?>
<div class="site-index">
  <div class="jumbotron">



    </div>

    <div class="body-content">

    <?php
    $con = \Yii:: $app->db;

    $sql = $con->createCommand("select * from post INNER JOIN user on post.user_id = user.id WHERE post.id = '$id'");
    $post = $sql->queryAll();

    $counter = $post[0]["megtekintes"] + 1;
    $sql = $con->createCommand("UPDATE post SET megtekintes = '$counter' WHERE id = '$id'");
    $sql->query();



  $date = strToTime($post[0]['update_time']);
      ?>
      <hr>
      <p><?= Html::a($post[0]['username'], ['general_profil', 'nev'=>$post[0]['username']])  ?></p>

      <?= Html::a(Html::img($post[0]['avatar'], ['width'=>40, 'height'=>40]))  ?>
      <h2>
        <?php echo nl2br($post[0]['text']); ?>
      </h2>
      <?= date("Y.m.d", $date)  ?>

      <p>Megtekintések száma <?= $counter ?> </p>

    </div>
</div>
