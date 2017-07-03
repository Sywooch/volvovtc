<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Mods extends ActiveRecord{

    public function rules(){
        return [
            [['category', 'subcategory', 'title'], 'required'],
            [['category', 'subcategory', 'title', 'file_name', 'yandex_link', 'gdrive_link', 'mega_link', 'author'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2048],
            [['picture'], 'string', 'max' => 45],
            [['game'], 'string', 'max' => 3],
            [['trailer'], 'safe'],
        ];
    }

    public static function visibleMod($id){
        $mod = Mods::findOne($id);
        $mod->visible = Yii::$app->request->get('action') == 'show' ? '1' : '0';
        return $mod->update() == 1 ? true : false;
    }

    public static function deleteMod($id){
        $mod = Mods::findOne($id);
        if(file_exists($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/mods/'.$mod->game.'/'.$mod->file_name)){
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/mods/'.$mod->game.'/'.$mod->file_name);
        }
        if($mod->picture && $mod->picture !== 'default.jpg') unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/mods/'.$mod->picture);
        return $mod->delete();
    }

    public static function resortMod($id){
        $mod = Mods::findOne($id);
        $mod_2 = Mods::find()->where(['game' => $mod->game, 'category' => $mod->category, 'subcategory' => $mod->subcategory]);
        if(Yii::$app->request->get('action') === 'sortup'){
            $mod_2 = $mod_2->andWhere(['>', 'sort', $mod->sort])->orderBy(['sort' => SORT_ASC]);
        }elseif(Yii::$app->request->get('action') === 'sortdown'){
            $mod_2 = $mod_2->andWhere(['<', 'sort', $mod->sort])->orderBy(['sort' => SORT_DESC]);
        }
        $mod_2 = $mod_2->one();
        if($mod_2 == null) return true;
        $modSort_2 = $mod_2->sort;
        $sortTmp = $modSort_2;
        $modSort_2 = $mod->sort;
        $mod->sort = $sortTmp;
        $mod_2->sort = $modSort_2;
        return $mod_2->update() == 1 && $mod->update() == 1 ? true : false;
    }

    public static function getTrailerData($mod){
        $description = '';
        $name = '';
        $image = 'mods/default.jpg';
        if($mod->trailer && !$mod->picture) {
            $trailer = \app\models\Trailers::findOne($mod->trailer);
            $image = 'trailers/'.$trailer->picture;
            $name = $trailer->name;
            $description = $trailer->description;
        }
        if($mod->picture){
            $image = 'mods/'. $mod->picture;
        }
        return [
            'image' => $image,
            'name' => $name,
            'description' => $description,
        ];
    }

    public static function getModByTrailer($trailer){
        if($trailer != '0' && $trailer != '-1'){
            $mod = Mods::findOne(['trailer' => $trailer]);
            return $mod ? $mod : false;
        }else{
            return false;
        }
    }

}
