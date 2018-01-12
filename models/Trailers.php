<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Trailers extends ActiveRecord{

    public static function deleteTrailer($id){
        $trailer = Trailers::findOne($id);
        if($trailer->picture && $trailer->picture !== 'default.jpg' && file_exists(Yii::$app->request->baseUrl).'/web/images/trailers/'.$trailer->picture){
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/trailers/'.$trailer->picture);
        }
        return $trailer->delete();
    }

    public static function getTrailers($append = array(), $game = null){
        $trailers_db = Trailers::find()->select(['id', 'name']);
        if($game != null) $trailers_db = $trailers_db->where(['game' => $game]);
        $trailers_db = $trailers_db->orderBy(['name' => SORT_ASC])->all();
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
        if($trailers[0] == '0' || $trailers[0] == '-1'){
            $list .= '<li class="trailer-name">';
            $list .= $trailers[0] == '0' ? 'Любой прицеп' : 'Без прицепа';
            $list .= '</li>';
        }
        $trailers = Trailers::getTrailersInfo($trailers);
        foreach ($trailers as $trailer){
            $list .= '<li class="trailer-name">'.$trailer->name;
            if($mod = Mods::findOne(['trailer' => $trailer, 'visible' => '1'])){
                $list .= ' - <a target="_blank" href="'.Yii::$app->request->baseUrl.'/mods/'.$mod->game.'/'.$mod->file_name.'" class="indigo-text light">'.
                    'Загрузить модификацию</a>';
            }else{
				$list .= ' - <a target="_blank" href="https://generator.volvovtc.com/" class="indigo-text light">'.
					'Сгенерировать модификацию</a>';
			}
            $list .= '<p><img src="/images/trailers/'.$trailer->picture.'" class="materialboxed responsive-img z-depth-2"></li>';

        }
        $list .= '</ul>';
        return $list ;
    }

}