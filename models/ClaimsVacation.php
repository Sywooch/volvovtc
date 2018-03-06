<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsVacation extends ActiveRecord{

	public $nickname;
	public $first_name;
	public $last_name;
	public $picture;
	public $v_member_id;

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

	public static function getClaims($limit = null){
		$claims = ClaimsVacation::find()
			->select([
				'claims_vacation.*',
				'users.nickname',
				'users.picture',
				'admin.first_name as first_name',
				'admin.last_name as last_name',
				'vtc_members.id as v_member_id'
			])
			->innerJoin('users', 'users.id = claims_vacation.user_id')
			->leftJoin('users as admin', 'admin.id = claims_vacation.viewed')
			->leftJoin('vtc_members', 'vtc_members.id = claims_vacation.member_id')
			->orderBy(['id'=> SORT_DESC]);
		if($limit) $claims = $claims->limit($limit);
		return $claims = $claims->all();
	}

}