<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsFired extends ActiveRecord{

	public $nickname;
	public $first_name;
	public $last_name;
	public $picture;
	public $v_member_id;

    public function rules(){
        return [
            [['member_id'], 'required'],
            [['member_id', 'viewed'], 'integer'],
            [['date'], 'safe'],
            [['status'], 'string', 'max' => 45],
            [['reason'], 'string', 'max' => 2048],
        ];
    }

	public static function getClaims($limit = null){
		$claims = ClaimsFired::find()
			->select([
				'claims_fired.*',
				'users.nickname',
				'users.picture',
				'admin.first_name as first_name',
				'admin.last_name as last_name',
				'vtc_members.id as v_member_id'
			])
			->innerJoin('users', 'users.id = claims_fired.user_id')
			->leftJoin('users as admin', 'admin.id = claims_fired.viewed')
			->leftJoin('vtc_members', 'vtc_members.id = claims_fired.member_id')
			->orderBy(['id'=> SORT_DESC]);
		if($limit) $claims = $claims->limit($limit);
		return $claims = $claims->all();
	}

}
