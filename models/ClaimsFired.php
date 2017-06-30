<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsFired extends ActiveRecord{

    public function rules(){
        return [
            [['member_id'], 'required'],
            [['member_id', 'viewed'], 'integer'],
            [['date'], 'safe'],
            [['status'], 'string', 'max' => 45],
            [['reason'], 'string', 'max' => 2048],
        ];
    }

}
