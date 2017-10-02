<?php

namespace app\models;

use Yii;
use yii\base\Model;

class FiredForm extends Model{

    public $id;
    public $reason;
    public $status;
    public $member_id;
    public $user_id;
    public $viewed;

    public function __construct($id = null){
        if(isset($id)){
            $claim = ClaimsFired::findOne($id);
            $this->member_id = $claim->member_id;
            $this->user_id = $claim->user_id;
            $this->reason = $claim->reason;
            $this->status = $claim->status;
            $this->viewed = $claim->viewed;
        }
    }

    public function rules(){
        return [
            [['reason'], 'string'],
            [['member_id', 'user_id', 'status', 'viewed'], 'integer'],
        ];
    }

    public function addClaim(){
        $claim = new ClaimsFired();
        $user = VtcMembers::find()->select(['id'])->where(['user_id' => Yii::$app->user->id])->one();
        $claim->member_id = $user->id;
        $claim->user_id = Yii::$app->user->id;
        $claim->reason = nl2br($this->reason);
        $claim->date = date('Y-m-d');
        Mail::newClaimToAdmin('на увольнение', $claim);
        return $claim->save();
    }

    public function editClaim($id) {
        $claim = ClaimsFired::findOne($id);
        $claim->status = $this->status;
        $claim->reason = $this->reason;
        $claim->viewed = $this->viewed;
        if($claim->save()) {
            if($this->status == '1') {
                $member = VtcMembers::findOne($claim->member_id);
                $user = User::findOne($claim->user_id);
                $user->company = '';
                $user->save();
                Notifications::addNotification('Ваше заявление на увольнение было одобрено', $this->user_id);
                return $member->delete() == 1;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function quickClaimApply($id){
        $claim = ClaimsFired::findOne($id);
        $claim->status = '1';
        $claim->viewed = Yii::$app->user->id;
        if($claim->save()) {
            $member = VtcMembers::findOne($claim->member_id);
            $user = User::findOne($claim->user_id);
            $user->company = '';
            $user->save();
            Notifications::addNotification('Ваше заявление на увольнение было одобрено', $claim->user_id);
            return $member->delete() == 1;
        }else{
            return false;
        }
    }

    public static function deleteClaim($id){
        $claim = ClaimsFired::findOne($id);
        return $claim->delete() == 1;
    }

    public function attributeLabels() {
        return [
            'reason' => 'Причина увольнения',
            'status' => 'Статус заявки',
        ];
    }

}