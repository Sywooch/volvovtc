<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RecruitForm extends Model{
    
    public $hear_from;
    public $invited_by;
    public $comment;
    public $reason;
    public $status;
    public $user_id;
    public $viewed;

    public function __construct($id = null){
        if(isset($id)){
            $claim = ClaimsRecruit::findOne($id);
            $this->user_id = $claim->user_id;
            $this->hear_from = str_replace("<br />","", $claim->hear_from);
            $this->invited_by = $claim->invited_by;
            $this->comment = str_replace("<br />","", $claim->comment);
            $this->reason = $claim->reason;
            $this->status = $claim->status;
            $this->viewed = $claim->viewed;
        }
    }

    public function rules(){
        return [
            [['hear_from', 'invited_by', 'comment', 'reason'], 'string'],
            [['user_id', 'status', 'viewed'], 'integer'],
        ];
    }

    public function addClaim(){
        $claim = new ClaimsRecruit();
        $claim->user_id = Yii::$app->user->id;
        $claim->invited_by = $this->invited_by;
        $claim->hear_from = nl2br($this->hear_from);
        $claim->comment = nl2br($this->comment);
        $claim->date = date('Y-m-d');
        Mail::newClaimToAdmin('на вступление', $claim);
        return $claim->save();
    }

    public function editRecruitClaim($id){
        $claim = ClaimsRecruit::findOne($id);
        $claim->status = $this->status;
        $claim->reason = $this->reason;
        $claim->invited_by = $this->invited_by;
        $claim->hear_from = $this->hear_from;
        $claim->viewed = $this->viewed;
        $claim->comment = $this->comment;
        if($claim->save()) {
            if($this->status == '1') {
                $member = new VtcMembers();
                $member->user_id = $this->user_id;
                $member->start_date = date('Y-m-d');
                $user = User::findOne($claim->user_id);
                $user->company = 'Volvo Trucks';
                $user->save();
                Notifications::addNotification('Вы были приняты в ряды водителей ВТК', $this->user_id);
                return $member->save();
            }else {
                return true;
            }
        }else{
            return false;
        }
    }

    public static function quickClaimApply($id){
        $claim = ClaimsRecruit::findOne($id);
        $claim->viewed = Yii::$app->user->id;
        $claim->status = '1';
        if($claim->save()) {
            $member = new VtcMembers();
            $member->user_id = $claim->user_id;
            $member->start_date = date('Y-m-d');
            $user = User::findOne($claim->user_id);
            $user->company = 'Volvo Trucks';
            $user->save();
            Notifications::addNotification('Вы были приняты в ряды водителей ВТК', $claim->user_id);
            return $member->save();
        }else{
            return false;
        }
    }

    public static function deleteRecruitClaim($id){
        $claim = ClaimsRecruit::findOne($id);
        return $claim->delete() == 1;
    }

    public function attributeLabels() {
        return [
            'hear_from' => 'Как вы узнали про ВТК Volvo Trucks?',
            'invited_by' => 'Кто Вас пригласил в ВТК Volvo Trucks?',
            'comment' => 'Ваш комментарий к заявке',
            'reason' => 'Причина (если отказ)',
            'status' => 'Статус заявки',
        ];
    }

}