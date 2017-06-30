<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsVacation extends ActiveRecord{

    public function rules(){
        return [
            [['member_id'], 'required'],
            [['member_id', 'viewed'], 'integer'],
            [['date', 'to_date'], 'safe'],
            [['reason'], 'string', 'max' => 512],
            [['status'], 'string', 'max' => 45],
            [['vacation_undefined'], 'integer'],
        ];
    }

}