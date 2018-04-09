<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ClaimsRecruit extends ActiveRecord{

	// invited
	public $i_id;
	public $i_company;
	public $i_nickname;

	// user
	public $uid;
	public $first_name;
	public $last_name;
	public $company;
	public $nickname;
	public $registered;
	public $birth_date;
	public $city;
	public $country;
	public $truckersmp;
	public $steam;
	public $vk;
	public $picture;

	// viewed
	public $a_first_name;
	public $a_last_name;

    public function rules(){
        return [
            [['user_id'], 'required'],
            [['user_id', 'status', 'viewed', 'invited_by'], 'integer'],
            [['date'], 'safe'],
            [['hear_from', 'reason'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 512],
        ];
    }

    public static function getStatusTitle($status){
        switch ($status){
            case '1': return 'Одобрено'; break;
            case '2': return 'Отказ'; break;
            case '3': return 'На удержании'; break;
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
				'admin.last_name as a_last_name',
				'invited.nickname as i_nickname',
				'invited.company as i_company',
				'invited.id as i_id'
			])
			->innerJoin('users', 'users.id = claims_recruit.user_id')
			->leftJoin('users as admin', 'admin.id = claims_recruit.viewed')
			->leftJoin('vtc_members', 'vtc_members.id = claims_recruit.invited_by')
			->leftJoin('users as invited', 'invited.id = vtc_members.user_id')
			->orderBy(['id'=> SORT_DESC]);
		if($limit) $claims = $claims->limit($limit);
		return $claims = $claims->all();
    }

}
