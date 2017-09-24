<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface{
    
//    public $id;
//    public $username;
//    public $password;
//    public $authKey;
//    public $accessToken;
    public $age;

    public static function tableName() {
        return 'users';
    }

    public static function findIdentity($id){
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){

    }

    public static function findByUsername($username){
        return User::findOne(['username' => $username]);
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
        return $this->auth_key;
    }

    public function validateAuthKey($authKey){
        return $this->auth_key === $authKey;
    }

    public function validatePassword($password){
        return password_verify($password, $this->password);
    }

    public static function getUserAge($birth_date){
        //var_dump($birth_date);
        if($birth_date != '0000-00-00' && $birth_date != null && $birth_date != ''){
            $birthday_timestamp = strtotime($birth_date);
            $age = date('Y') - date('Y', $birthday_timestamp);
            if(date('md', $birthday_timestamp) > date('md')) $age--;
            $last_number = $age % 10;
            if(($last_number > 0 && $last_number < 5) && ($age > 20 || $age < 10)){
                if(($last_number == 1) && ($age > 20 || $age < 10)) $let = $age . ' год';
                else $let = $age . ' года';
            }
            else $let = $age . ' лет';
            return $let;
        }else{
            return false;
        }
    }

    public static function isAdmin(){
        return !Yii::$app->user->isGuest && Yii::$app->user->identity->admin == '1';
    }

    public static function isVtcMember($id = null){
        if(isset($id)){
            $user = User::findOne($id);
            $is_member = VtcMembers::find()->where(['user_id' => $user->id])->count() !== '0';
        }else {
            if(Yii::$app->user->isGuest) {
                $is_member = false;
            } else {
                $is_member = VtcMembers::find()
                    ->where(['user_id' => Yii::$app->user->identity->id])
                    ->one() ? true : false;
            }
        }
        return $is_member;
    }

    public static function generatePasswordResetString($email){
        $user = User::findOne(['email' => $email]);
        if($user){
            $user->password_reset = Yii::$app->security->generateRandomString(64);
            if($user->update() !== false){
                return $user->password_reset;
            }
        }
        return false;
    }

    public static function setUserActivity($id){
        $user = User::findOne($id);
        $user->last_active = date('Y-m-d H:i');
        $user->update();
    }

    public static function isOnline($user){
        if($user->last_active){
            $last_active = new \DateTime($user->last_active);
            $now = new \DateTime();
            $interval = $last_active->diff($now);
            $years = $interval->format('%y');
            $months = $interval->format('%m');
            $days = $interval->format('%d');
            $hours = $interval->format('%h');
            $minutes = $interval->format('%i');
            if($years == '0' && $months == '0' && $days == '0' && $hours == '0' && intval($minutes) < 3) return true;
        }
        return false;
    }

}