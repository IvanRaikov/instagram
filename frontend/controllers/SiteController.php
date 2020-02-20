<?php
namespace frontend\controllers;

use yii\web\Controller;
use frontend\models\User;
use Yii;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
  
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex(){
        if(Yii::$app->user->isGuest){
            return $this->redirect('/user/default/login');
        }
        $currentUser = Yii::$app->user->identity;
        $limit = Yii::$app->params['feedPostLimit'];
        $feedItems = $currentUser->getFeed($limit);
        return $this->render('index',[
            'feedItems'=>$feedItems,
            'currentUser'=>$currentUser
        ]);
    }
    public function actionMoreFeeds(){
        $offset = Yii::$app->request->post('offset');
        Yii::$app->response->format = Response::FORMAT_JSON;
        $currentUser = Yii::$app->user->identity;
        $limit = Yii::$app->params['feedPostLimit'];
        $feedItems = $currentUser->getMoreFeed($limit, $offset);
        return $feedItems;
    }
}
