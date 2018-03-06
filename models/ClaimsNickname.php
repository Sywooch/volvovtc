<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsNickname extends ActiveRecord{

	public $nickname;
	public $first_name;
	public $last_name;
	public $picture;
	public $v_member_id;

    public function rules(){
        return [
            [['member_id', 'viewed'], 'integer'],
            [['new_nickname', 'old_nickname'], 'required'],
            [['date'], 'safe'],
            [['new_nickname', 'status', 'old_nickname'], 'string', 'max' => 45],
        ];
    }

	public static function getClaims($limit = null){
		$claims = ClaimsNickname::find()
			->select([
				'claims_nickname.*',
				'users.nickname',
				'users.picture',
				'admin.first_name as first_name',
				'admin.last_name as last_name',
				'vtc_members.id as v_member_id'
			])
			->innerJoin('users', 'users.id = claims_nickname.user_id')
			->leftJoin('users as admin', 'admin.id = claims_nickname.viewed')
			->leftJoin('vtc_members', 'vtc_members.id = claims_nickname.member_id')
			->orderBy(['id'=> SORT_DESC]);
		if($limit) $claims = $claims->limit($limit);
		return $claims = $claims->all();
	}

}