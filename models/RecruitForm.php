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

    public $first_name;
    public $last_name;
    public $birth_date;
    public $city;
    public $country;
    public $steam;
    public $vk;

    public $user;

    public function __construct($id = null){
        $this->user = User::findOne(Yii::$app->user->id);
        $this->steam = $this->user->steam;
        $this->vk = $this->user->vk;
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->birth_date = $this->user->birth_date;
        $this->city = $this->user->city;
        $this->country = $this->user->country;
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
            [['steam', 'vk', 'first_name', 'last_name', 'birth_date', 'city', 'country'], 'required', 'message' => 'Заполдните все обязательные поля'],
            [['steam'], 'url', 'message' => 'Неверная ссылка Steam', 'defaultScheme' => 'https'],
            [['vk'], 'url', 'message' => 'Неверная ссылка VK', 'defaultScheme' => 'https'],
            [['steam', 'vk', 'first_name', 'last_name', 'birth_date', 'city', 'country'], 'checkUserAttributes']
        ];
    }

    public function checkUserAttributes($attribute, $params){
        if($this->$attribute){
            switch ($attribute){
                case 'first_name' : $this->user->first_name = $this->first_name; break;
                case 'last_name' : $this->user->last_name = $this->last_name; break;
                case 'birth_date' : $this->user->birth_date = $this->birth_date; break;
                case 'country' : $this->user->country = $this->country; break;
                case 'city' : $this->user->city = $this->city; break;
                case 'vk' : {
                    $regex = '%^(https?:\/\/)?vk.com\/[^\/]*\/?$%';
                    if(!preg_match($regex, $this->vk)){
                        $this->addError($attribute, 'Укажите профиль ВК в виде "<b>http://vk.com/</b><i>ваш_id</i>"');
                        $this->vk = '';
                    }else{
                        $this->user->vk = $this->vk;
                    }
                    break;
                }
                case 'steam' : {
                    if(!$this->validateUrl('steam', $this->steam)){
                        $this->addError($attribute, 'Укажите профиль Steam в виде "<b>http://steamcommunity.com/</b><i>id,profiles</i><b>/</b><i>ваш_id</i>"');
                        $this->steam = '';
                    }else{
                        $this->user->steam = $this->steam;
                        $this->user->steamid = Steam::getUser64ID($this->steam);
                        $this->user->truckersmp = $this->user->steamid ? 'https://truckersmp.com/user/' . TruckersMP::getUserID($this->user->steamid) : null;
                    }
                }
            }
        }
    }

    public static function validateUrl($service, $url){
        switch ($service){
            case 'vk' : $regex = '%^(https?:\/\/)?vk.com\/[^\/]{1,}\/?$%'; break;
            case 'steam' :
            default : $regex = '%^(https?:\/\/)?steamcommunity\.com\/(id|profiles)\/[^\/]{1,}\/?$%'; break;
        }
        return preg_match($regex, $url) ? true : false;
    }

    public function afterValidate() {
        $this->user->update();
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

    public function editClaim($id){
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

    public static function deleteClaim($id){
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