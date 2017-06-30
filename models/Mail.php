<?php

namespace app\models;


use Yii;
use yii\helpers\Url;

class Mail{

    public static function newUserToAdmin($data = []){

        $to = [
            "viiper94@gmail.com", // Mayday
            "a.borisov97@mail.ru", // Canyon
        ];

        $subject = "Новый пользователь на сайте VolvoVTC.com";

        Yii::$app->mailer->compose('admin/newuser', [
            'data' => $data,
            'subject' => $subject
        ])->setFrom('info@volvovtc.com')
            ->setTo($to)
            ->setSubject($subject)
            ->send();

        return true;

    }

    public static function newClaimToAdmin($claim, $data = []){

        $to = [
            "viiper94@gmail.com", // Mayday
            "a.borisov97@mail.ru", // Canyon
            "racer16@inbox.lv", // Fox
            "lankin.i91@gmail.com", // Forward
        ];

        $subject = "Новое заявление на сайте VolvoVTC.com";

        Yii::$app->mailer->compose('admin/newclaim', [
            'claim' => $claim,
            'user' => User::findOne($data->user_id),
            'data' => $data,
            'subject' => $subject
        ])->setFrom('info@volvovtc.com')
            ->setTo($to)
            ->setSubject($subject)
            ->send();

        return true;

    }

    public static function sendResetPassword($string, $email){

        $subject = "Сброс пароля на сайте VolvoVTC.com";

        Yii::$app->mailer->compose('user/reset_pwd', [
            'email' => $email,
            'url' => 'https://volvovtc.com/reset?u='.$string,
        ])->setFrom('info@volvovtc.com')
            ->setTo($email)
            ->setSubject($subject)
            ->send();

        return true;

    }

}