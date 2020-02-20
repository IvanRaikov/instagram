<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'id',
             'format'=>'raw',
             'value'=>function ($post) {
             return Html::a($post->id, ['view', 'id' => $post->id]);
             }],
            'user_id',
            ['attribute' => 'file_name',
             'format' => 'raw',
             'value' => function ($post) {
             return Html::img(Yii::$app->storage->getFile($post->file_name), ['width'=>'130px']);
             }],
            'description:ntext',
            'created_at:datetime',
            'complaints',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}&nbsp&nbsp&nbsp{approve}&nbsp&nbsp&nbsp{delete}',
             'buttons' => [
                 'approve' => function ($url ,$post) {
                    return Html::a("<i class='glyphicon glyphicon-ok'></i>", ['approve', 'id'=>$post->id]);
                 }
                ]
            ],
        ]
    ]); ?>
</div>
