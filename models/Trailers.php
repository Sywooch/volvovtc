<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Trailers extends ActiveRecord{

    public static function deleteTrailer($id){
        $trailer = Trailers::findOne($id);
        if($trailer->picture && file_exists(Yii::$app->request->baseUrl).'/web/images/trailers/'.$trailer->picture){
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/trailers/'.$trailer->picture);
        }
        return $trailer->delete();
    }

    public static function getTrailers($append = array()){
        $trailers_db = Trailers::find()->select(['id', 'name'])->orderBy(['name' => SORT_ASC])->all();
        foreach ($append as $key => $value) {
            $trailers[$key] = $value;
        }
        foreach ($trailers_db as $trailer) {
            $trailers[$trailer->id] = $trailer->name;
        }
        return $trailers;
    }

    public static function getTrailersInfo($trailers){
        $query = Trailers::find()->select(['picture', 'name', 'description']);
        foreach ($trailers as $trailer){
            $query = $query->orWhere(['id' => $trailer]);
        }
        return $query->all();
    }

    public static function getTrailersListHtml($trailers){
        $list = '<ul class="trailers-list browser-default">';
        foreach ($trailers as $trailer){
            $list .= '<li><p class="trailer-name">'.$trailer->name;
            if($mod = Mods::findOne(['trailer' => $trailer, 'visible' => '1'])){
                $list .= ' - <a target="_blank" href="'.Yii::$app->request->baseUrl.'/mods/'.$mod->game.'/'.$mod->file_name.'" class="indigo-text light">'.
                            'Загрузить модификацию</a>';
            }
            $list .= '<p><img src="/images/trailers/'.$trailer->picture.'" class="materialboxed responsive-img z-depth-2"></li>';
        }
        return $list.'</ul>';
    }

}