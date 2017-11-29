<?php

namespace app\models;

use DateTime;
use Yii;
use yii\db\ActiveRecord;

class VtcMembers extends ActiveRecord{

    public $banned = false;

    public static function tableName(){
        return 'vtc_members';
    }

    public function rules(){
        return [
            [['user_id'], 'required'],
            [['user_id', 'can_lead', 'can_center', 'can_close', 'scores_total', 'scores_month', 'scores_other',
                'exam_driving', 'exam_3_cat', 'exam_2_cat', 'exam_1_cat', 'post_id', 'vacation_undefined'], 'integer'],
            [['vacation', 'start_date'], 'safe'],
            [['additional'], 'string', 'max' => 1024],
            [['scores_history'], 'string', 'max' => 2048],
            [['scores_updated'], 'safe'],
            [['user_id'], 'unique'],
        ];
    }

    public static function getMembers($get_bans = false){
        $members = array();
        $posts = array();
        $all_members = VtcMembers::find()->orderBy('post_id DESC, `scores_month` + `scores_other` DESC, scores_total DESC, start_date')->all();
        $positions = VtcPositions::find()->select(['id'])->all();
        foreach($positions as $position){
            $posts[] = $position->id;
        }
        foreach($all_members as $member){
            if(in_array($member->post_id, $posts)){
                $member->user_id = User::findOne($member->user_id);
                $member->post_id = VtcPositions::find()->where(['id' => $member->post_id])->one();
                if($member->user_id->truckersmp != '' && $get_bans){
                    $member->banned = TruckersMP::isMemberBanned($member->user_id->truckersmp);
                }
                if($member->post_id->admin == '1') $members['Администрация'][] = $member;
                else $members[$member->post_id->name][] = $member;
            }
        }
        return $members;
    }

    public static function getAllMembers($order_by_start_date = true){
        $members =  VtcMembers::find();
        if($order_by_start_date) $members = $members->orderBy('start_date');
        $members = $members->all();
        foreach($members as $member){
            $member->user_id = User::findOne($member->user_id);
        }
        return $members;
    }

    public static function getMembersArray(){
        $all_members = self::getAllMembers(false);
        $members = array();
        foreach ($all_members as $member){
            $members[$member->id] = '[Volvo Trucks] '.$member->user_id->nickname;
        }
        return $members;
    }

    public static function fireMember($id){
        $member = VtcMembers::findOne($id);
        $user = User::findOne($member->user_id);
        $user->company = '';
        $user->save();
        return $member->delete() !== false;
    }

    public static function addScores($id, $scores, $target){
        $member = VtcMembers::findOne($id);
        if($target == 'month'){
            $member->scores_month = intval($member->scores_month) + intval($scores);
            $member->scores_total = intval($member->scores_total) + intval($scores);
        }elseif($target = 'other'){
            $member->scores_other = intval($member->scores_other) + intval($scores);
            $member->scores_total = intval($member->scores_total) + intval($scores);
        }
        $member->additional = self::updateAdditionalByScores($member);
        $member->scores_updated = date('Y-m-d H:i');
        $member->scores_history = self::setScoresHistory($member->scores_history, ['total' => $member->scores_total, 'month' => $member->scores_month, 'other' => $member->scores_other]);
        if($member->update() !== false){
            Notifications::addNotification('Вам было начислено '. $scores . ' баллов!', $member->user_id);
            return ['other' => $member->scores_other, 'month' => $member->scores_month, 'total' => $member->scores_total, 'updated' => date('d.m.y H:i')];
        }
        return false;
    }

    public static function updateAdditionalByScores($member){
        $additional = '';
        if($member->post_id == '2' && $member->scores_total >= 100) $additional = 'На 3 категорию';
        if(($member->post_id == '3' || $member->post_id == '2') && $member->scores_total >= 200) $additional = 'На 2 категорию';
        if(($member->post_id == '4' || $member->post_id == '3' || $member->post_id == '2') && $member->scores_total >= 400) $additional = 'На 1 категорию';
        return $additional;
    }

    public static function cleanVacations(){
        $members = VtcMembers::find()->where(['!=', 'vacation', ''])->all();
        foreach($members as $member){
            $vacation = new \DateTime($member->vacation);
            $now = new \DateTime();
            if($vacation < $now){
                $member->vacation = '';
                $member->save();
            }
        }
    }

    public static function zeroScores(){
        $members = VtcMembers::find()->all();
        foreach($members as $member){
            $member->scores_other = 0;
            $member->scores_month = 0;
            $member->update();
        }
    }

    public static function getBans($steamid64){
        $bans = array();
        foreach ($steamid64 as $uid => $steamid){
            $user = User::findOne($uid);
            $bans[$uid] = TruckersMP::isMemberBanned($user->truckersmp);
        }
        return $bans;
    }

    public static function getMemberNickname($id){
        $member = VtcMembers::findOne($id);
        $user = User::findOne($member->user_id);
        $truckersmp = TruckersMP::getMemberTruckersMpNickname($user->steamid);
        $steam = Steam::getPlayerNickname($user->steamid);
        if(strpos($truckersmp, '[Volvo Trucks]') !== false){
            return str_replace(['[Volvo Trucks]', '[Volvo Trucks] '], '', $truckersmp);
        }else if(strpos($steam, '[Volvo Trucks]') !== false){
            return str_replace(['[Volvo Trucks]', '[Volvo Trucks] '], '', $steam);
        }else{
            return $user->nickname;
        }
    }

    public static function getMemberDays($start_date){
        $datetime1 = new DateTime($start_date);
        $datetime2 = new DateTime();
        $days = intval($datetime1->diff($datetime2)->format('%a'));
        if($days == 1) $days .= ' день';
        else if($days > 1 && $days < 5) $days .= ' дня';
        else if($days == 0 || $days >= 5 && $days < 21) $days .= ' дней';
        else if($days > 20){
            $last_digit = $days > 100 ? $days % 100 : $days % 10;
            if($last_digit == 1) $days .= ' день';
            else if($last_digit > 1 && $last_digit < 5) $days .= ' дня';
            else if($last_digit == 0 || $last_digit >= 5 && $last_digit < 21) $days .= ' дней';
            else if($last_digit > 20){
                $last_digit = $last_digit % 10;
                if($last_digit == 1) $days .= ' день';
                else if($last_digit > 1 && $last_digit < 5) $days .= ' дня';
                else if($last_digit == 0 || $last_digit >= 5) $days .= ' дней';
            }
        }
        return $days;
    }

    public static function setScoresHistory($scores_history, $scores){
        $new_score['date'] = date('Y-m-d H:i');
        $new_score['total'] = $scores['total'];
        $new_score['month'] = $scores['month'];
        $new_score['other'] = $scores['other'];
        $new_score['admin'] = Yii::$app->user->id;
        if($scores_history){
            $member_scores = unserialize($scores_history);
            if(count($member_scores) >= 20){
                $member_scores = array_slice($member_scores, 0, 19);
            }
            array_unshift($member_scores, $new_score);
            $scores_history = serialize($member_scores);
        }else{
            $scores_history = serialize([$new_score]);
        }
        return $scores_history;
    }

}