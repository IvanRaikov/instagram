<?php
namespace frontend\modules\user\controllers;

use yii\web\Controller;
use frontend\models\User;
use Yii;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller{
    
    public function actionView($nickname){
        $user = $this->getUserByNickname($nickname);
        $currentUser = Yii::$app->user->identity;
        $subscriptions = $user->getSubscriptions();
        $followers = $user->getFollowers();
        $countFollowers = $user->countFollowers();
        $countSubscriptions = $user->countSubscriptions();
        return $this->render('view',['user'=>$user,
                             'subscriptions'=>$subscriptions,
                             'followers'=>$followers,
                             'countFollowers'=>$countFollowers,
                             'countSubscriptions'=>$countSubscriptions,
                             'currentUser'=>$currentUser
                ]);
    }
    public function actionSubscribe($id){
        if(Yii::$app->user->isGuest){
            $this->redirect('/user/default/login');
        }
        $currentUser = Yii::$app->user->identity;
        $user = $this->getUserById($id);
        $currentUser->fallowUser($user);
        return $this->redirect(['/user/profile/view', 'nickname'=>$user->getNickname()]);
    }
    public function actionUnsubscribe($id){
        if(Yii::$app->user->isGuest){
            $this->redirect('/user/default/login');
        }
        $currentUser = Yii::$app->user->identity;
        $user = $this->getUserById($id);
        $currentUser->unfallowUser($user);
        return $this->redirect(['/user/profile/view', 'nickname'=>$user->getNickname()]);
    }
    public function getUserByNickname($nickname){
        if($user = User::find()->where(['nickname'=>$nickname])->orWhere(['id'=>$nickname])->one()){
            return $user;
        }
        throw new NotFoundHttpException();
    }
    public function getUserById($id){
        if($user = User::findOne($id)){
            return $user;
        }
        throw new NotFoundHttpException();
    }
}

