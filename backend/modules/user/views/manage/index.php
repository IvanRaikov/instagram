<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'picture',
             'format' => 'raw',
             'value' => function($user){
                return Html::img($user->getPicture(), ['width'=>'100px']);
             }],
            ['attribute' => 'roles',
             'format' => 'raw', 
             'value' => function($user){
                 return implode(' ',$user->getUserRoles());
             }],
            'username',
            'email:email',
            'status',
            'created_at:datetime',
            'nickname',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
