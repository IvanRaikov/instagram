<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'picture',
             'format' => 'raw',
             'value' => function ($user) {
                return Html::img($user->getPicture(), ['width'=>'300px']);
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
            'updated_at:datetime',
            'about:ntext',
            'type',
            'nickname',
        ],
    ]) ?>

</div>
