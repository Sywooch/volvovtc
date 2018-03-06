<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsRecruit extends ActiveRecord{

	public $first_name;
	public $last_name;
	public $a_first_name;
	public $a_last_name;
	public $picture;

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

	public static function getClaims($limit = null){
		$claims = ClaimsRecruit::find()
			->select([
				'claims_recruit.*',
				'users.first_name',
				'users.last_name',
				'users.picture',
				'admin.first_name as a_first_name',
				'admin.last_name as a_last_name'
			])
			->innerJoin('users', 'users.id = claims_recruit.user_id')
			->leftJoin('users as admin', 'admin.id = claims_recruit.viewed')
			->orderBy(['id'=> SORT_DESC]);
		if($limit) $claims = $claims->limit($limit);
		return $claims = $claims->all();
    }

}
