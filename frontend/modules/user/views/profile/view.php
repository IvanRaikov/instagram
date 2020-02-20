<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>


<div class="user-profile">
<div class="user-info">
    <img class="main-avatar" src="<?=$user->getPicture()?>">
<h3 class="user-username"><?= Html::encode($user->username)?></h3>

</div>
<div class="about-user">
    <h3 class="user-nickname"><?=$user->nickname?></h3>
    <p><strong>Обо мне </strong> <?= HtmlPurifier::process($user->about)?></p>
</div>
    <div class="buttons">
        <?php if($currentUser && $currentUser->equals($user)):?>
            <a class="btn btn-info" href="<?= Url::to(['/user/profile/upload-picture'])?>">загрузить фото</a>
            <a class="btn btn-info" href="<?= Url::to(['/post/default/create'])?>">добавить пост</a>
        <?php else:?>
            <a class="btn btn-info" href="<?= Url::to(['/user/profile/subscribe', 'id'=>$user->id])?>">подписаться</a>
            <a class="btn btn-info" href="<?= Url::to(['/user/profile/unsubscribe', 'id'=>$user->id])?>">отписатся</a>
        <?php endif;?>
            <a class="btn btn-info show-friends">подписки и подписчики</a>
    </div>
</div>
<div class="posts">
    <?php foreach($posts as $post):?>
    <div class="post">
        <img class="post-img" data-id="<?=$post->id?>" src="/uploads/<?=$post->file_name?>">
    </div>
    <?php endforeach;?>
    <div class="pages"><?= LinkPager::widget(['pagination'=>$pagination])?></div>
</div>


<div class="post-view">
    <div class="close-post-view"><i class="fa fa-close"></i></div>
    
    <div class="post-big-img">
        <img src="/uploads/2c/d7/51384f754fab3b926467ba072f8ec0dc9f4f.jpg">
    </div>
    <div class="post-info">
        <p class="description"></p>
        <p class="likes fa fa-heart"></p>
                <a class="btn btn-primary button-like" data-id=""><i class="fa fa-thumbs-up"></i></a>
                <a class="btn btn-primary button-dislike" ><i class="fa fa-thumbs-down"></i></a>
                <a class="btn btn-default button-report" data-id=""> пожаловаться</a><i class="fa fa-cog fa-spin fa-fw icon-spinner" style="display:none"></i>
        
    </div>
</div>
<div class="modal-window" >
    <div class="close-friends-view"><i class="fa fa-close"></i></div>
    <div class="friends">
        <h3>подписки <?=$countSubscriptions?></h3>
        <?php foreach($subscriptions as $subscription):?>
        <ul>
            <li>
                <img class="friends-list-avatar" src="<?=$subscription->getPicture()?>">
                <a href="<?= Url::to(['/user/profile/view', 'nickname'=>$subscription->getNickname()])?>"><?=$subscription->username?></a><br>
            </li>
        </ul>
        
        <?php endforeach;?>    
        <hr>
        <h3>подписчики <?=$countFollowers?></h3>
        <?php foreach($followers as $follower):?>
        <ul>
            <li>
                <img class="friends-list-avatar" src="<?=$follower->getPicture()?>">
                <a href="<?= Url::to(['/user/profile/view', 'nickname'=>$follower->getNickname()])?>"><?=$follower->username?></a><br>
            </li>
        </ul>
        <?php endforeach;?>
        <?php if($currentUser):
        $commonFriends = $currentUser->getCommonfriends($user)?>
        <hr>
        <h3>общие друзья</h3>
        <?php foreach($commonFriends as $friend):?>
            <ul>
            <li>
                <img class="friends-list-avatar" src="<?=$friend->getPicture()?>">
                <a href="<?= Url::to(['/user/profile/view', 'nickname'=>$friend->getNickname()])?>"><?=$friend->username?></a><br>
            </li>
        </ul>
        <?php endforeach;?>
        <?php endif;?>
    </div>
</div>

<?php $this->registerJsFile('@web/js/view-post.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);
$this->registerJsFile('@web/js/likes.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);
$this->registerJsFile('@web/js/reports.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);
$this->registerJsFile('@web/js/show-friends.js',[
    'depends'=> yii\web\JqueryAsset::className()
]);?>


