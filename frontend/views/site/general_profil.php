<?php
use frontend\models\UploadForm;
use yii\helpers\Html;

$default = "frontend/web/profilimages/default.jpg";
$model = new UploadForm();
/* @var $this yii\web\View */

$this->title = 'A Twatter mindenek felett';
?>
<div class="site-profil">

    <div class="jumbotron">


        <p class="lead"><?=  $model->getdata($nev)[0]['username']  ?></p>


<img src=" <?= $model->getdata($nev)[0]['avatar'] ?> " style="width: 40px; height: 40px;" />
</div>

<div class="body-content">

<?php
$con = \Yii:: $app->db;

$sql = $con->createCommand("select post.id, user.username, user.avatar, post.text, post.update_time, post.megtekintes from post INNER JOIN user on post.user_id = user.id where user.username = '$nev' order by post.id desc");

$posts = $sql->query();



if(!$posts) {

    echo "Nincsennek még posztok!";
}

else {
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
<?php }

}
?>




    </div>
