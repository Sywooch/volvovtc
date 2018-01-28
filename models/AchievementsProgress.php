<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class AchievementsProgress extends ActiveRecord{

    public function rules(){
        return [
            [['ach_id', 'uid', 'proof'], 'required'],
            [['ach_id', 'uid', 'complete'], 'integer'],
            [['proof'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'ach_id' => 'Ach ID',
            'uid' => 'Uid',
            'proof' => 'Progress',
        ];
    }

    public static function getAchievement($uid, $achid, $file){
        $ach = new AchievementsProgress();
        $ach->ach_id = $achid;
        $ach->uid = $uid;
        switch ($file['type']){
            case 'image/png': $ext = '.png'; break;
            case 'image/gif': $ext = '.gif'; break;
            case 'image/jpeg' :
            default: $ext = '.jpg';
        }
        $ach->proof = $uid.'-'.$achid.'-'.time().$ext;
        if(move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/achievements/progress/' . $ach->proof)){
            return $ach->save();
        }else{
            return false;
        }
    }

    public static function applyAchievement($id){
        $ach = AchievementsProgress::findOne($id);
        $ach->complete = 1;
        $user_progress = AchievementsProgress::find()->where(['uid' => $ach->uid, 'ach_id' => $ach->ach_id, 'complete' => 1])->all();
        $achievement = Achievements::findOne($ach->ach_id);
        $result = true;
        if(($achievement->progress > 1 && count($user_progress)+1 == $achievement->progress) || $achievement->progress == 1){
            $user = User::findOne($ach->uid);
            if($user->achievements == null){
                $user->achievements = serialize([$ach->ach_id]);
            }else{
                $achievements = unserialize($user->achievements);
                $achievements[] = $ach->ach_id;
                $user->achievements = serialize($achievements);
            }
            if($member = VtcMembers::findOne(['user_id' => $user->id])){
            	$scores = intval($achievement->scores);
				$member->scores_other = intval($member->scores_other) + $scores;
				$member->scores_total = intval($member->scores_total) + $scores;
				$member->update();
			}
            $result = $user->update() !== false;
        }
        return $result && $ach->update() !== false;
    }

    public static function denyAchievement($id){
        $ach = AchievementsProgress::findOne($id);
        if(file_exists($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/achievements/progress/'.$ach->proof)){
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/achievements/progress/'.$ach->proof);
        }
        return $ach->delete() !== false;
    }
}