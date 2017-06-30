<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Other extends ActiveRecord{

    public function rules(){
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['category'], 'string', 'max' => 45],
            [['text'], 'string', 'max' => 20000],
            [['id'], 'unique'],
        ];
    }

    public static function updateRules($text){
        $rules = Other::findOne(['category' => 'rules']);
        $rules->text = $text;
        return $rules->update() !== false;
    }
}
