<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Achievements extends ActiveRecord{

    public function rules(){
        return [
            [['title', 'date', 'sort'], 'required'],
            [['visible', 'sort', 'progress', 'related'], 'integer'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 512],
            [['description'], 'string', 'max' => 2048],
            [['image'], 'string', 'max' => 64],
        ];
    }

    public static function removeAchievement($id){
        $ach = Achievements::findOne($id);
        if($ach->image !== 'default.jpg' && file_exists($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/achievements/'.$ach->image)){
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/achievements/'.$ach->image);
        }
        return $ach->delete();
    }

    public static function resortAchievement($id, $dir){
        $ach = Achievements::findOne($id);
        $ach2_query = Achievements::find();
        if($dir === 'up'){
            $ach2_query = $ach2_query->andWhere(['>', 'sort', $ach->sort])->orderBy(['sort' => SORT_ASC]);
        }elseif($dir === 'down'){
            $ach2_query = $ach2_query->andWhere(['<', 'sort', $ach->sort])->orderBy(['sort' => SORT_DESC]);
        }
        $ach2 = $ach2_query->one();
        if($ach2 == null) return false;
        $sortTmp = $ach2->sort;
        $ach2->sort = $ach->sort;
        $ach->sort = $sortTmp;
        return $ach->update() == 1 && $ach2->update() == 1 ? true : false;
    }

}