<div class="row">
    <div class="col-md-12">
        <img class="col-md-8" src="/uploads/<?= $post->file_name?>">
    </div>
    <div class="col-md-12">
        <strong><?= $user->username?></strong>
        <?= $post->description?>
        <br>
        <p id="likes" class="fa fa-heart"> <?= $post->countLikes()?></p>
        <a class="btn btn-primary button-like <?= $currentUser && $post->isLikedBy($currentUser)? 'display-none': ''?>" data-id="<?=$post->id?>">like </a>
        <a class="btn btn-primary button-dislike <?= $currentUser && $post->isLikedBy($currentUser)? '' : 'display-none'?>" data-id="<?=$post->id?>"> dislike</a>
    </div>
    
</div>
<?php $this->registerJsFile('@web/js/likes.js',[
    'depends'=> yii\web\JqueryAsset::className()
])?>