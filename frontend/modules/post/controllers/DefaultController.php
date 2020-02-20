<?php

namespace frontend\modules\post\controllers;

use frontend\models\User;
use yii\web\Controller;
use frontend\modules\post\models\PostForm;
use Yii;
use yii\web\UploadedFile;
use frontend\models\Post;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{
    public function actionCreate(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('/user/default/login');
        }
        $model = new PostForm(Yii::$app->user->identity);
        if($model->load(Yii::$app->request->post())){
            $model->picture = UploadedFile::getInstance($model, 'picture');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'пост добавлен');
                return $this->redirect(['/user/profile/view','nickname'=>Yii::$app->user->identity->getNickname()]);
            }
        }
        return $this->render('create',[
            'model'=>$model
        ]);
    }
    public function actionView($id){
        $post = $this->findPost($id);
        $isLikedBy = Yii::$app->user->identity->isLikedBy($id);
        $response['file_name'] = $post->file_name;
        $response['created_at'] = $post->created_at;
        $response['description'] = $post->description;
        $response['is_reported'] = $post->isReported(Yii::$app->user->identity);
        $response['is_liked_by'] = $isLikedBy;
        $response['count_likes'] = $post->countLikes();
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $response;
    }
    public function findPost($id){
        if($post = Post::findOne($id)){
            return $post;
        }
        throw new NotFoundHttpException();
    }
    public function actionLike(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('/user/default/login');
        }
        $postId = Yii::$app->request->post('id');
        $post = Post::findOne($postId);
        $currentUser = Yii::$app->user->identity;
        return $post->like($currentUser);
    }
    public function actionDislike(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('/user/default/login');
        }
        $postId = Yii::$app->request->post('id');
        $post = Post::findOne($postId);
        $currentUser = Yii::$app->user->identity;
        return $post->dislike($currentUser);
    }
    public function actionComplain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $currentUser = Yii::$app->user->identity;
        $post = $this->findPost($id);
        if ($post->complain($currentUser)) {
            return[
                'text'=>'жалоба принята'
            ];
        }
            return[
                'text'=>'произошла ошибка'
            ];
    }
    
}
