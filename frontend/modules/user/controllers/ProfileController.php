<?php
namespace frontend\modules\user\controllers;

use yii\web\Controller;
use frontend\models\User;
use Yii;
use yii\web\NotFoundHttpException;
use frontend\modules\user\models\PictureForm;
use yii\web\UploadedFile;
use yii\data\Pagination;
use frontend\models\Post;

class ProfileController extends Controller{
    
    public function actionView($nickname){
        $user = $this->getUserByNickname($nickname);
        $currentUser = Yii::$app->user->identity;
        $subscriptions = $user->getSubscriptions();
        $followers = $user->getFollowers();
        $countFollowers = $user->countFollowers();
        $countSubscriptions = $user->countSubscriptions();
        $query = Post::find()->where(['user_id'=>$user->id]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count, 'pageSize'=>8]);
        $posts = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('view',['user'=>$user,
                             'subscriptions'=>$subscriptions,
                             'followers'=>$followers,
                             'countFollowers'=>$countFollowers,
                             'countSubscriptions'=>$countSubscriptions,
                             'currentUser'=>$currentUser,
                             'posts'=>$posts,
                             'pagination'=>$pagination
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
    public function actionUploadPicture(){
        $model = new PictureForm();
        $model->picture = UploadedFile::getInstance($model, 'picture');
        if(Yii::$app->request->isPost){
            $user = Yii::$app->user->identity;
            $user->picture = Yii::$app->storage->saveUploadedFile($model->picture);
            if($user->save(false, ['picture'])){
                $this->redirect(['/user/profile/view', 'nickname'=>$user->getNickname()]);
            }
        }
        return $this->render('uploadPicture', [
            'model'=>$model
        ]);
    }
}

