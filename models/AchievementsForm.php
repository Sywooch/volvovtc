<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AchievementsForm extends Model{

    public $title;
    public $description;
    public $image;
    public $related;
    public $progress = 1;
    public $visible = true;

    public function __construct($id = null){
        if(isset($id)){
            $achievement = Achievements::findOne($id);
            $this->title = $achievement->title;
            $this->description = $achievement->description;
            $this->visible = $achievement->visible == '1';
            $this->image = $achievement->image;
            $this->progress = $achievement->progress;
            $this->related = $achievement->related;
        }
    }

    public function rules() {
        return [
            [['title'], 'required', 'message' => 'Обязательное поле'],
            [['description'], 'string'],
            [['image'], 'file', 'extensions' => ['png', 'jpg']],
            [['visible'], 'boolean'],
            [['progress'], 'integer', 'min' => 1],
            [['related'], 'integer']
        ];
    }

    public function attributeLabels(){
        return [
            'title' => 'Название*',
            'description' => 'Описание',
            'image' => 'Изображение',
            'progress' => 'Количество этапов',
            'related' => 'От какого достижения зависит'
        ];
    }

    public function addAchievement(){
        $last_achievement = Achievements::find()->orderBy(['sort' => SORT_DESC])->one();
        $achievement = new Achievements();
        $achievement->title = $this->title;
        $achievement->description = $this->description;
        $achievement->visible = $this->visible ? '1' : '0';
        $achievement->progress = $this->progress;
        $achievement->date = date('Y-m-d');
        $achievement->related = $this->related;
        $achievement->sort = ($last_achievement ? intval($last_achievement->sort) : 0)+1;
        if($achievement->save() == 1){
            if($file = UploadedFile::getInstance($this, 'image')){
                $achievement->image = $achievement->id . '.' . $file->extension;
                $file->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/achievements/' . $achievement->image);
                return $achievement->update() !== false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    public function editAchievement($id){
        $achievement = Achievements::findOne($id);
        $achievement->title = $this->title;
        $achievement->description = $this->description;
        $achievement->related = $this->related;
        $achievement->progress = $this->progress;
        $achievement->visible = $this->visible ? '1' : '0';
        if($file = UploadedFile::getInstance($this, 'image')){
            $achievement->image = $achievement->id . '.' . $file->extension;
            $file->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/achievements/' . $achievement->image);
        }
        return $achievement->update() !== false;
    }

}