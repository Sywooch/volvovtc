<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class TrailersForm extends Model{

    public $id;
    public $name;
    public $picture;
    public $description;
    public $game = 'ets';

    public function rules(){
        return [
            [['name'], 'required', 'message' => 'Введите название трейлера'],
            [['description', 'game'], 'string'],
            [['picture'], 'file']
        ];
    }

    public function __construct($id = null){
        if(isset($id)){
            $trailer = Trailers::findOne($id);
            $this->id = $trailer->id;
            $this->name = $trailer->name;
            $this->description = $trailer->description;
            $this->game = $trailer->game;
            $this->picture = $trailer->picture;
        }
    }

    public function addTrailer(){
        $trailer = new Trailers();
        $trailer->name = $this->name;
        $trailer->description = $this->description;
        $trailer->game = $this->game;
        if($picture = UploadedFile::getInstance($this, 'picture')){
            $trailer->picture = $trailer->id.'-f.'.$picture->extension;
            $picture->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/trailers/'.$trailer->picture);
        }
        return $trailer->save();
    }

    public function editTrailer($id){
        $trailer = Trailers::findOne($id);
        $trailer->name = $this->name;
        $trailer->description = $this->description;
        $trailer->game = $this->game;
        if($picture = UploadedFile::getInstance($this, 'picture')){
            $trailer->picture = $trailer->id.'-f.'.$picture->extension;
            $picture->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/trailers/'.$trailer->picture);
        }
        return $trailer->update() != false;
    }

    public function attributeLabels(){
        return [
            'name' => 'Название трейлера',
            'description' => 'Описание',
            'picture' => 'Изображение',
            'game' => 'Игра',
        ];
    }

}