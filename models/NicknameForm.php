<?php

namespace app\models;

use Yii;
use yii\base\Model;

class NicknameForm extends Model{

    public $new_nickname;
    public $old_nickname;
    public $reason;
    public $status;
    public $member_id;
    public $user_id;
    public $viewed;

    public function __construct($id = null){
        if(isset($id)){
            $claim = ClaimsNickname::findOne($id);
            $this->member_id = $claim->member_id;
            $this->user_id = $claim->user_id;
            $this->new_nickname = $claim->new_nickname;
            $this->old_nickname = $claim->old_nickname;
            $this->reason = $claim->reason;
            $this->status = $claim->status;
            $this->viewed = $claim->viewed;
        }
    }

    public function rules(){
        return [
            [['new_nickname'], 'required', 'message' => 'Укажите новый никнейм'],
            [['new_nickname', 'reason'], 'string'],
            [['member_id', 'user_id', 'status', 'viewed'], 'integer'],
        ];
    }

    public function addClaim(){
        $claim = new ClaimsNickname();
        $user = VtcMembers::find()->select(['id'])->where(['user_id' => Yii::$app->user->id])->one();
        $claim->member_id = $user->id;
        $claim->user_id = Yii::$app->user->id;
        $claim->new_nickname = $this->new_nickname;
        $claim->old_nickname = Yii::$app->user->identity->nickname;
        $claim->date = date('Y-m-d');
        Mail::newClaimToAdmin('на смену ника', $claim);
        return $claim->save();
    }

    public function editClaim($id){
        $claim = ClaimsNickname::findOne($id);
        $claim->status = $this->status;
        $claim->reason = $this->reason;
        $claim->viewed = $this->viewed;
        $claim->new_nickname = $this->new_nickname;
        if($claim->save()) {
            if($this->status == '1') {
                $member = VtcMembers::find()->select(['user_id'])->where(['id' => $claim->member_id])->one();
                $user = User::findOne($member->user_id);
                $user->nickname = $this->new_nickname;
                Notifications::addNotification('Ваше заявление на смену ника было одобрено', $member->user_id);
                return $user->save();
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function quickClaimApply($id){
        $claim = ClaimsNickname::findOne($id);
        $claim->status = '1';
        $claim->viewed = Yii::$app->user->id;
        if($claim->save()) {
            $member = VtcMembers::find()->select(['user_id'])->where(['id' => $claim->member_id])->one();
            $user = User::findOne($member->user_id);
            $user->nickname = $claim->new_nickname;
            Notifications::addNotification('Ваше заявление на смену ника было одобрено', $member->user_id);
            return $user->save();
        }else{
            return false;
        }
    }

    public static function deleteClaim($id){
        $claim = ClaimsNickname::findOne($id);
        return $claim->delete() == 1;
    }

    public function attributeLabels() {
        return [
            'new_nickname' => 'Новый никнейм',
            'reason' => 'Причина (если отказ)',
            'status' => 'Статус заявки',
        ];
    }

}