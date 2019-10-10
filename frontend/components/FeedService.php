<?php
namespace frontend\components;
use yii\base\Event;
use yii\base\Component;
use frontend\models\Feed;
/**
 * Description of FeedService
 *
 * @author Lenovo
 */
class FeedService extends Component{
    public function addToFeeds(Event $event){
        $user = $event->getUser();
        $post = $event->getPost();
        $followers = $user->getFollowers();
        foreach($followers as $follower){
            $feedItem = new Feed();
            $feedItem->user_id = $follower->id;
            $feedItem->autor_id = $user->id;
            $feedItem->autor_name = $user->username;
            $feedItem->autor_nickname = $user->getNickname();
            $feedItem->autor_picture = $user->getPicture();
            $feedItem->post_id = $post->id;
            $feedItem->post_filename = $post->file_name;
            $feedItem->post_description = $post->description;
            $feedItem->post_created_at = $post->created_at;
            $feedItem->save();
        }
    }
}
