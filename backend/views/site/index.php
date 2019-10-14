<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
use yii\helpers\Url;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p><a class="btn btn-default" href="<?=Url::to('/complaints/manage')?>">Manage &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
