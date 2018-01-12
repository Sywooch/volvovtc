<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddConvoyForm extends Model{

    public $picture_full;
    public $picture_small;
    public $extra_picture;
    public $add_info;
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
    public $trailer = array(['0']);
    public $truck_var;
    public $communications;
    public $author;
    public $game;
    public $visible = true;
    public $open = false;
    public $dlc = array();
    public $map_remove = false;
    public $attach_var_photo = false;

    public function __construct($id = null){
        if(isset($id)){
            $convoy = Convoys::findOne($id);
            $this->start_city = $convoy->start_city;
            $this->picture_small = $convoy->picture_small;
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
            $this->trailer = unserialize($convoy->trailer);
            $this->truck_var = explode(',', $convoy->truck_var)[0];
            $this->attach_var_photo = explode(',', $convoy->truck_var)[1] == '1';
            $this->title = $convoy->title;
            $this->communications = $convoy->communications;
            $this->visible = $convoy->visible;
            $this->open = $convoy->open;
            $this->extra_picture = $convoy->extra_picture;
            $this->add_info = $convoy->add_info;
            $this->author = $convoy->author;
            $this->game = $convoy->game;
            $this->dlc = unserialize($convoy->dlc);
        }
    }

    public function rules() {
        return [
            [['start_city', 'start_company', 'finish_city', 'finish_company', 'server', 'departure_time', 'date'], 'required'],
            [['rest', 'description', 'length', 'title', 'communications', 'meeting_time'], 'string'],
            [['extra_picture', 'picture_full', 'picture_small'], 'file', 'extensions' => 'png, jpg', 'maxSize' => 16500000],
            [['open', 'visible', 'map_remove', 'attach_var_photo'], 'boolean'],
            [['add_info', 'author', 'game'], 'string'],
            [['dlc', 'trailer', 'truck_var'], 'safe']
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'extra_picture' => 'Дополнительное изображение',
            'add_info' => 'Дополнительная информация',
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
            'trailer' => 'Трейлер',
            'truck_picture' => 'Изображение тягача',
            'truck_var' => 'Вариации тягача',
            'title' => 'Название конвоя',
            'communications' => 'Связь',
            'author' => 'Конвой сделал',
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
        foreach ($this->trailer as $trailer){
            if(!(($trailer == '0' || $trailer == '-1') && count($this->trailer) > 1)){
                $trailers[] = $trailer;
            }
        }
        $convoy->trailer = serialize(array_unique($trailers));
        $convoy->truck_var = $this->truck_var.','.intval($this->attach_var_photo);
        $convoy->title = $this->title;
        $convoy->open = $this->open;
        $convoy->dlc = serialize($this->dlc);
        $convoy->visible = $this->visible;
        $convoy->communications = $this->communications;
        $convoy->add_info = $this->add_info;
        $convoy->author = $this->author;
        $convoy->game = Yii::$app->request->get('game');
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
            if($trailer = UploadedFile::getInstance($this, 'extra_picture')){
                $convoy->extra_picture = $convoy->id.'-1.'.$trailer->extension;
                $trailer->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->extra_picture);
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
        if($convoy->departure_time != $date->format('Y-m-d ').$this->departure_time.':00'){
            $convoy->participants = null;
        }
        $convoy->departure_time = $date->format('Y-m-d ').$this->departure_time;
        $convoy->meeting_time = $date->format('Y-m-d ').$this->meeting_time;
        if(new \DateTime($convoy->departure_time) > new \DateTime()){
            $convoy->scores_set = '0';
        }
        foreach ($this->trailer as $trailer){
            if(!(($trailer == '0' || $trailer == '-1') && count($this->trailer) > 1)){
                $trailers[] = $trailer;
            }
        }
        $convoy->trailer = serialize(array_unique($trailers));
        $convoy->truck_var = $this->truck_var.','.intval($this->attach_var_photo);
        $convoy->title = $this->title;
        $convoy->open = $this->open;
        $convoy->dlc = serialize($this->dlc);
        $convoy->visible = $this->visible;
        $convoy->communications = $this->communications;
        $convoy->add_info = $this->add_info;
        $convoy->author = $this->author;
        $convoy->updated = date('Y-m-d H:i');
        $convoy->updated_by = Yii::$app->user->id;
        if($this->map_remove){
            $convoy->picture_full = null;
            $convoy->picture_small = null;
        }else{
            if($map_full = UploadedFile::getInstance($this, 'picture_full')){
                $convoy->picture_full = $convoy->id.'-f.'.$map_full->extension;
                $convoy->picture_small = $convoy->id.'-f.'.$map_full->extension;
                $map_full->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_full);
            }
            if($map_small = UploadedFile::getInstance($this, 'picture_small')){
                $convoy->picture_small = $convoy->id.'-s.'.$map_small->extension;
                $map_small->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_small);
            }
        }
        if($trailer = UploadedFile::getInstance($this, 'extra_picture')){
            $convoy->extra_picture = $convoy->id.'-1.'.$trailer->extension;
            $trailer->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->extra_picture);
        }
        return $convoy->update() !== false;
    }

}