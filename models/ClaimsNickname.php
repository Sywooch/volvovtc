<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsNickname extends ActiveRecord{

    public function rules(){
        return [
            [['member_id', 'viewed'], 'integer'],
            [['new_nickname', 'old_nickname'], 'required'],
            [['date'], 'safe'],
            [['new_nickname', 'status', 'old_nickname'], 'string', 'max' => 45],
        ];
    }

}
