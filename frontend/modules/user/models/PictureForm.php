<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\modules\user\models;
use yii\base\Model;

/**
 * Description of ImageUpload
 *
 * @author Lenovo
 */
class PictureForm extends Model{
    public $picture;
    
    public function rules(){
        return [
            [['picture'],'file', 'extensions'=>['jpg', 'png'], 'checkExtensionByMimeType'=>true]
    ];
    }
    
}
