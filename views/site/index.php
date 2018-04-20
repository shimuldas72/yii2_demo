<?php

use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Demo Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Yii2 Demo Application!</h1>

        <p><a class="btn btn-lg btn-success" href="<?= Url::toRoute(['user/index']); ?>">Get started</a></p>
    </div>

</div>
