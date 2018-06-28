<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$message = "Hiba lépett fel."
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Valószínűleg nem található a keresett oldal.
    </p>
    <p>
        Ha úgy gondolja, hogy szerveres meghibásodás lehet az oka, kérem vegye fel velünk a kapcsolatot!
    </p>

</div>
