<?php
namespace frontend\modules\post\models;
use yii\base\Model;
use Yii;
use frontend\models\User;
use app\models\Post;
use frontend\models\events\PostCreatedEvent;

class PostForm extends Model{
    const MAX_DESCRIPTION_LENGTH = 1000;
    const EVENT_POST_CREATED = 'post_created';
    public $picture;
    public $description;
    private $user;
    
    public function __construct(User $user) {
        $this->user = $user;
        $this->on(SELF::EVENT_POST_CREATED, [Yii::$app->feedService, 'addToFeeds']);
    }
    public function rules(){
        return[
          [['picture'],'file',
              'skipOnEmpty'=>false,
              'extensions'=>['jpg'],
              'checkExtensionByMimeType'=>true,
              'maxSize'=>$this->getMaxFileSize()],
           [['description'],'string','max'=>SELF::MAX_DESCRIPTION_LENGTH]
        ];
    }
    public function getMaxFileSize(){
        return Yii::$app->params['maxFileSize'];
    }
    public function save(){
    if($this->validate()){
        $post = new Post();
        $post->user_id = $this->user->id;
        $post->description = $this->description;
        $post->created_at = time();
        $post->file_name = Yii::$app->storage->saveUploadedFile($this->picture);
        if($post->save(false)){
            $event = new PostCreatedEvent();
            $event->user = $this->user;
            $event->post = $post;
            $this->trigger(SELF::EVENT_POST_CREATED, $event);
            return true;
        }
        return false;
    }
    }
}
