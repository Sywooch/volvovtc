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

    public static function countClaims($claims, $status = true){
        if(!$status){
            return count($claims);
        }else{
            $count = 0;
            foreach ($claims as $claim){
//                var_dump($claim->status);
                if($claim->status == '0'){
                    $count++;
                }
            }
            return $count;
        }
    }


}
