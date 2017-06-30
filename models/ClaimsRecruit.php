<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsRecruit extends ActiveRecord{

    public function rules(){
        return [
            [['user_id'], 'required'],
            [['user_id', 'status', 'viewed'], 'integer'],
            [['date'], 'safe'],
            [['invited_by', 'hear_from', 'reason'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 512],
        ];
    }

    public static function getStatusTitle($status){
        switch ($status){
            case '1': return 'Одобрено'; break;
            case '2': return 'Отказ'; break;
            case '0':
            default : return 'Рассматривается'; break;
        }
    }

}
