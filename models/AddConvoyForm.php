<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddConvoyForm extends Model{

    public $picture_full;
    public $picture_small;
    public $start_city;
    public $start_company;
    public $finish_city;
    public $finish_company;
    public $rest;
    public $description;
    public $server = 'eu2_ets';
    public $length;
    public $title;
    public $departure_time;
    public $meeting_time;
    public $date;
    public $trailer_picture;
    public $trailer_name;
    public $truck_picture;
    public $truck_var = '1';
    public $communications;
    public $visible = true;
    public $open = false;
    public $dlc_ge = false;
    public $dlc_s = false;
    public $dlc_vlv = false;
    public $dlc = array();

    public function __construct($id = null){
        if(isset($id)){
            $convoy = Convoys::findOne($id);
            $this->start_city = $convoy->start_city;
            $this->start_company = $convoy->start_company;
            $this->finish_city = $convoy->finish_city;
            $this->finish_company = $convoy->finish_company;
            $this->rest = $convoy->rest;
            $this->description = $convoy->description;
            $this->server = $convoy->server;
            $this->length = $convoy->length;
            $d_time = new \DateTime($convoy->departure_time);
            $m_time = new \DateTime($convoy->meeting_time);
            $this->departure_time = $d_time->format('H:i');
            $this->meeting_time = $m_time->format('H:i');
            $this->date = $d_time->format('Y-m-d');
            $this->trailer_name = $convoy->trailer_name;
            $this->truck_var = $convoy->truck_var;
            $this->title = $convoy->title;
            $this->communications = $convoy->communications;
            $this->visible = $convoy->visible;
            $this->open = $convoy->open;
            $this->dlc = unserialize($convoy->dlc);
        }
    }

    public function rules() {
        return [
            [['start_city', 'start_company', 'finish_city', 'finish_company', 'server', 'departure_time', 'date'], 'required'],
            [['rest', 'description', 'length', 'trailer_name', 'truck_var', 'title', 'communications', 'meeting_time'], 'string'],
            [['open', 'visible'], 'boolean'],
            [['dlc'], 'safe']
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'picture_full' => 'Ссылка на оригинал маршрута',
            'picture_small' => 'Ссылка на превью маршрута',
            'start_city' => 'Стартовый город',
            'start_company' => 'Стартовое место',
            'finish_city' => 'Конечный город',
            'finish_company' => 'Конечное место',
            'rest' => 'Точка отдыха',
            'description' => 'Описание',
            'server' => 'Сервер',
            'length' => 'Протяженность маршрута',
            'departure_time' => 'Время выезда (по МСК)',
            'meeting_time' => 'Время сбора (по МСК)',
            'date' => 'Дата проведения конвоя',
            'trailer_picture' => 'Изображение груза/трейлера',
            'trailer_name' => 'Название груза/трейлера',
            'truck_picture' => 'Изображение тягача',
            'truck_var' => 'Вариация тягача',
            'title' => 'Название конвоя',
            'communications' => 'Связь',
        ];
    }

    public function addConvoy(){
        $convoy = new Convoys();
        $convoy->start_city = $this->start_city;
        $convoy->start_company = $this->start_company;
        $convoy->finish_city = $this->finish_city;
        $convoy->finish_company = $this->finish_company;
        $convoy->rest = $this->rest;
        $convoy->description = $this->description;
        $convoy->server = $this->server;
        $convoy->length = $this->length;
        $date = new \DateTime($this->date);
        $convoy->departure_time = $date->format('Y-m-d ').$this->departure_time;
        $convoy->meeting_time = $date->format('Y-m-d ').$this->meeting_time;
        $convoy->date = $this->date;
        $convoy->trailer_name = $this->trailer_name;
        $convoy->truck_var = $this->truck_var;
        $convoy->title = $this->title;
        $convoy->open = $this->open;
        $convoy->dlc = serialize($this->dlc);
        $convoy->visible = $this->visible;
        $convoy->communications = $this->communications;
        if($convoy->save() == 1){
            if($map_full = UploadedFile::getInstance($this, 'picture_full')){
                $convoy->picture_full = $convoy->id.'-f.'.$map_full->extension;
                $convoy->picture_small = $convoy->id.'-f.'.$map_full->extension;
                $map_full->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_full);
            }
            if($map_small = UploadedFile::getInstance($this, 'picture_small')){
                $convoy->picture_small = $convoy->id.'-s.'.$map_small->extension;
                $map_small->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_small);
            }
            if($trailer = UploadedFile::getInstance($this, 'trailer_picture')){
                $convoy->trailer_picture = $convoy->id.'.jpg';
                $trailer->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/trailers/'.$convoy->trailer_picture);
            }
            $convoy->update();
            return $convoy->id;
        }else{
            return false;
        }
    }

    public function editConvoy($id){
        $convoy = Convoys::findOne($id);
        $convoy->start_city = $this->start_city;
        $convoy->start_company = $this->start_company;
        $convoy->finish_city = $this->finish_city;
        $convoy->finish_company = $this->finish_company;
        $convoy->rest = $this->rest;
        $convoy->description = $this->description;
        $convoy->server = $this->server;
        $convoy->length = $this->length;
        $convoy->date = $this->date;
        $date = new \DateTime($this->date);
        $convoy->departure_time = $date->format('Y-m-d ').$this->departure_time;
        $convoy->meeting_time = $date->format('Y-m-d ').$this->meeting_time;
        $convoy->trailer_name = $this->trailer_name;
        $convoy->truck_var = $this->truck_var;
        $convoy->title = $this->title;
        $convoy->open = $this->open;
        $convoy->dlc = serialize($this->dlc);
        $convoy->visible = $this->visible;
        $convoy->communications = $this->communications;
        if($map_full = UploadedFile::getInstance($this, 'picture_full')){
            $convoy->picture_full = $convoy->id.'-f.'.$map_full->extension;
            $convoy->picture_small = $convoy->id.'-f.'.$map_full->extension;
            $map_full->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_full);
        }
        if($map_small = UploadedFile::getInstance($this, 'picture_small')){
            $convoy->picture_small = $convoy->id.'-s.'.$map_small->extension;
            $map_small->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_small);
        }
        if($trailer = UploadedFile::getInstance($this, 'trailer_picture')){
            $convoy->trailer_picture = $convoy->id.'.jpg';
            $trailer->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/trailers/'.$convoy->trailer_picture);
        }
        return $convoy->update() !== false ? true : false;
    }

    private function getTimeParam($string, $param = 'h'){
        $array = explode(':', $string);
        switch($param){
            case 'm' : return $array[1];
            case 'h' :
            default : return $array[0];
        }
    }

}