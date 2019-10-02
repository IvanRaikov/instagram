<?php
namespace frontend\modules\user\controllers;

use yii\web\Controller;
use frontend\models\User;

class ProfileController extends Controller{
    
    public function actionView($id){
        $user = User::findOne(['id'=>$id]);
        return $this->render('view',['user'=>$user]);
    }
}

