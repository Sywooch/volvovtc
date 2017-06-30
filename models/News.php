<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class News extends ActiveRecord{

    public function rules(){
        return [
            [['date', 'title', 'sort'], 'required'],
            [['date'], 'safe'],
            [['sort', 'visible'], 'integer'],
            [['text'], 'string', 'max' => 17000],
            [['picture'], 'string', 'max' => 2048],
            [['title', 'subtitle'], 'string', 'max' => 255],
        ];
    }

    public static function resortNews($id){
        $news = News::findOne($id);
        $news_2 = News::find();
        if(Yii::$app->request->get('action') === 'sortup'){
            $news_2 = $news_2->where(['>', 'sort', $news->sort])->orderBy(['sort' => SORT_ASC]);
        }elseif(Yii::$app->request->get('action') === 'sortdown'){
            $news_2 = $news_2->where(['<', 'sort', $news->sort])->orderBy(['sort' => SORT_DESC]);
        }
        $news_2 = $news_2->one();
        if($news_2 == null) return false;
        $newsSort_2 = $news_2->sort;
        $sortTmp = $newsSort_2;
        $newsSort_2 = $news->sort;
        $news->sort = $sortTmp;
        $news_2->sort = $newsSort_2;
        return $news_2->update() == 1 && $news->update() == 1 ? true : false;
    }

    public static function deleteNews($id){
        $news = News::findOne($id);
        if($news->picture !== 'default.jpg'){
            $pics = unserialize($news->picture);
            foreach ($pics as $pic){
                if($pic != 'default.jpg') unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/news/'.$pic);
            }
        }
        return $news->delete();
    }

    public static function visibleNews($id){
        $news = News::findOne($id);
        $news->visible = Yii::$app->request->get('action') == 'show' ? '1' : '0';
        return $news->update() == 1 ? true : false;
    }

    public static function addAjaxImage($file){
        $file_name = time().'_'.$file['name'];
        $dir = $_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/news/' . $file_name;
        if(move_uploaded_file($file['tmp_name'], $dir)){
            return [
                'name' => $file_name,
                'path' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir)
            ];
        }else{
            return false;
        }
    }

}
