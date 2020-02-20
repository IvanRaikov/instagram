<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
    <div class="body-content">

        <div class="feed-line">
            <?php foreach($feedItems as $item):?>
            <hr>
            <article>
                <div class="feed-autor">
                    <a href="/profile/<?=$item->autor_nickname?$item->autor_nickname:$item->autor_id?>"><img src="<?= $item->autor_picture?>">
                    <?=$item->autor_name?></a>
                </div>
                <div class="feed-img">
                    <img  src="/uploads/<?=$item->post_filename?>"><br>
                </div>
              
                    <?= $item->post_description?>
               
                <div>
                    <?= Yii::$app->formatter->asDatetime($item->post_created_at)?>
                    
                </div>
                <div>
                    <p class="likes fa fa-heart"> <?= $item->countLikes()?></p>
                    <a class="btn btn-primary button-like <?= $currentUser->isLikedBy($item->post_id)? 'display-none': ''?>" data-id="<?=$item->post_id?>"><i class="fa fa-thumbs-up"></i></a>
                    <a class="btn btn-primary button-dislike <?= $currentUser->isLikedBy($item->post_id)? '' : 'display-none'?>" data-id="<?=$item->post_id?>"><i class="fa fa-thumbs-down"></i></a>
                    <a class="btn btn-default button-report <?= $item->isReported($currentUser)?'disabled':''?>" data-id="<?=$item->post_id?>"> пожаловаться</a><i class="fa fa-cog fa-spin fa-fw icon-spinner" style="display:none"></i>
                </div>
            </article>
            <?php endforeach;?>
            
        </div>
        <div>
            <a data-offset="<?= Yii::$app->params['feedPostLimit']?>" data-limit="<?= Yii::$app->params['feedPostLimit']?>" id="more-feeds" ><i class="fa fa-arrow-down"></i></a>
        </div>
    </div>

<?php $this->registerJsFile('@web/js/likes.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);
$this->registerJsFile('@web/js/reports.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);
$this->registerJsFile('@web/js/more-feeds.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);?>
