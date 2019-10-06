<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
?>
<img src="<?=$user->getPicture()?>" style="max-width:200px;">
<h3><?= Html::encode($user->username)?></h3>
<p><?= HtmlPurifier::process($user->about)?></p>
<a class="btn btn-info" href="<?= Url::to(['/user/profile/upload-picture'])?>">загрузить фото</a>
<a class="btn btn-info" href="<?= Url::to(['/user/profile/subscribe', 'id'=>$user->id])?>">подписаться</a>
<a class="btn btn-info" href="<?= Url::to(['/user/profile/unsubscribe', 'id'=>$user->id])?>">отписатся</a>
<h3>подписки <?=$countSubscriptions?></h3>
<?php foreach($subscriptions as $subscription):?>
<a href="<?= Url::to(['/user/profile/view', 'nickname'=>$subscription->getNickname()])?>"><?=$subscription->username?></a><br>
<?php endforeach;?>    

<hr>
<h3>подписчики <?=$countFollowers?></h3>
<?php foreach($followers as $follower):?>
    <a href="<?= Url::to(['/user/profile/view', 'nickname'=>$follower->getNickname()])?>"><?=$follower->username?></a><br>
<?php endforeach;?>
<?php if($currentUser):
    $commonFriends = $currentUser->getCommonfriends($user)?>
<h3>общие друзья</h3>
<?php foreach($commonFriends as $friend):?>
    <a href="<?= Url::to(['/user/profile/view', 'nickname'=>$friend->getNickname()])?>"><?=$friend->username?></a><br>
<?php endforeach;?>
<?php endif;?>

