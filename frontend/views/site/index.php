<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
    <div class="body-content">

        <div class="col-lg-8">
            
            
            <?php foreach($feedItems as $item):?>
                <div class="col-md-12">
                    <a href="/profile/<?=$item->autor_nickname?$item->autor_nickname:$item->autor_id?>"><img class="feedAutorPicture" src="<?= $item->autor_picture?>">
                    <?=$item->autor_name?></a>
                </div>
                <div class="col-lg-12">
                    <img class="col-lg-12" src="/uploads/<?=$item->post_filename?>"><br>
                </div>
                <div class="col-lg-12">
                    <?= $item->post_description?>
                </div>
                <div class="col-lg-12">
                    <?= Yii::$app->formatter->asDatetime($item->post_created_at)?>
                    
                </div>
            <div class="col-md-12">
                <p class="likes fa fa-heart"> <?= $item->countLikes()?></p>
                <a class="btn btn-primary button-like <?= $currentUser->isLikedBy($item->post_id)? 'display-none': ''?>" data-id="<?=$item->post_id?>"><i class="fa fa-thumbs-up"></i></a>
                <a class="btn btn-primary button-dislike <?= $currentUser->isLikedBy($item->post_id)? '' : 'display-none'?>" data-id="<?=$item->post_id?>"><i class="fa fa-thumbs-down"></i></a>
                <a class="btn btn-default button-report <?= $item->isReported($currentUser)?'disabled':''?>" data-id="<?=$item->post_id?>"> пожаловаться</a><i class="fa fa-cog fa-spin fa-fw icon-spinner" style="display:none"></i>
                <hr><hr>
            </div>
            
            <?php endforeach;?>
            
        </div>

    </div>
</div>
<?php $this->registerJsFile('@web/js/likes.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);
$this->registerJsFile('@web/js/reports.js',[
    'depends'=> yii\web\JqueryAsset::className()
])?>
