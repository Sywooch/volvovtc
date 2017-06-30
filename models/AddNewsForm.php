<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddNewsForm extends Model{

    public $picture;
    public $title;
    public $subtitle;
    public $text;
    public $visible = true;

    public function __construct($id = null){
        if(isset($id)){
            $convoy = News::findOne($id);
            $this->picture = $convoy->picture;
            $this->title = $convoy->title;
            $this->subtitle = $convoy->subtitle;
            $this->text = str_replace('<br />', '', $convoy->text);
            $this->visible = $convoy->visible;
        }
    }

    public function rules() {
        return [
            [['title'], 'required'],
            [['text', 'subtitle', 'title'], 'string'],
            [['visible'], 'boolean'],
        ];
    }

    public function attributeLabels(){
        return [
            'title' => 'Заголовок новости',
            'picture' => 'Изображение новости',
            'text' => 'Текст новости',
            'subtitle' => 'Подзаголовок новости',
            'visible' => 'Видима',
        ];
    }

    public function addNews($pics = null){
        $last_news = News::find()->orderBy(['sort' => SORT_DESC])->one();
        $news = new News();
        $news->title = $this->title;
        $news->text = nl2br($this->text);
        $news->subtitle = $this->subtitle;
        $news->picture = serialize($pics);
        $news->date = date('y-m-d');
        $news->visible = $this->visible;
        $news->sort = ($last_news ? intval($last_news->sort) : 0)+1;
        if($news->save()){
            return $news->id;
        }else{
            return false;
        }
    }

    public function editNews($id, $pics = null){
        $news = News::findOne($id);
        $news->title = $this->title;
        $news->text = nl2br($this->text);
        $news->subtitle = $this->subtitle;
        if($old_pics = unserialize($news->picture)){
            foreach($old_pics as $old_pic){
                if(!in_array($old_pic, $pics) && $old_pic != 'default.jpg')
                    unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/news/'.$old_pic);
            }
        }
        $news->picture = serialize($pics);
        $news->visible = $this->visible;
        return $news->update() == 1 ? true : false;
    }

}