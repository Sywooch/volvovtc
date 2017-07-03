<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddModForm extends Model{

    public $category;
    public $title;
    public $description;
    public $picture;
    public $file;
    public $yandex_link;
    public $gdrive_link;
    public $mega_link;
    public $author;
    public $warning;
    public $trailer;

    public function __construct($id = null){
        if(isset($id)){
            $mod = Mods::findOne($id);
            $this->category = implode('/', [$mod->game, $mod->category, $mod->subcategory]);
            $this->title = $mod->title;
            $this->description = $mod->description;
            $this->warning = $mod->warning;
            $this->picture = $mod->picture;
            $this->yandex_link = $mod->yandex_link;
            $this->gdrive_link = $mod->gdrive_link;
            $this->mega_link = $mod->mega_link;
            $this->author = $mod->author;
            $this->trailer = $mod->trailer;
        }
    }

    public function rules(){
        return [
            [['category', 'title'], 'required'],
            [['title', 'yandex_link', 'gdrive_link', 'mega_link', 'author', 'warning'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2048],
            [['trailer'], 'safe'],
        ];
    }

    public function attributeLabels(){
        return [
            'category' => 'Категория',
            'title' => 'Название модификации',
            'description' => 'Описание модификации',
            'warning' => 'Предупреждение',
            'picture' => 'Изображение',
            'yandex_link' => 'Ссылка в Yandex',
            'gdrive_link' => 'Ссылка в Google Drive',
            'mega_link' => 'Ссылка в MEGA',
            'author' => 'Автор модификации',
            'trailer' => 'Трейлер',
        ];
    }

    public function addMod(){
        $last_mod = Mods::find()->orderBy(['sort' => SORT_DESC])->one();
        $mod = new Mods();
        $category = explode('/', $this->category);
        $mod->game = $category[0];
        $mod->category = $category[1];
        $mod->subcategory = $category[2];
        $mod->title = $this->title;
        $mod->description = $this->description;
        $mod->warning = $this->warning;
        $mod->yandex_link = $this->yandex_link;
        $mod->gdrive_link = $this->gdrive_link;
        $mod->mega_link = $this->mega_link;
        $mod->author = $this->author;
        $mod->trailer = $this->trailer == '0' ? null : $this->trailer;
        $mod->sort = ($last_mod ? intval($last_mod->sort) : 0)+1;
        if($file = UploadedFile::getInstance($this, 'file')){
            $mod->file_name = $this->transliterate($file->name);
            $file->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/mods/'.$mod->game.'/'.$mod->file_name);
        }
        if($mod->save()){
            if($img = UploadedFile::getInstance($this, 'picture')){
                $mod->picture = $mod->id.'.'.$img->extension;
                $img->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/mods/'.$mod->picture);
                return $mod->update();
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    public function editMod($id){
        $mod = Mods::findOne($id);
        $category = explode('/', $this->category);
        $mod->game = $category[0];
        $mod->category = $category[1];
        $mod->subcategory = $category[2];
        $mod->title = $this->title;
        $mod->description = $this->description;
        $mod->warning = $this->warning;
        $mod->yandex_link = $this->yandex_link;
        $mod->gdrive_link = $this->gdrive_link;
        $mod->mega_link = $this->mega_link;
        $mod->author = $this->author;
        $mod->trailer = $this->trailer == '0' ? null : $this->trailer;
        if($this->trailer != '0') {
            if(file_exists($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/mods/'.$mod->picture)){
                unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/mods/'.$mod->picture);
            }
            $mod->picture = null;
        }
        $pic_change = false;
        $file_change = false;
        if($file = UploadedFile::getInstance($this, 'file')){
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/mods/'.$mod->game.'/'.$mod->file_name);
            $mod->file_name = $this->transliterate($file->name);
            $file->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/mods/'.$mod->game.'/'.$mod->file_name);
            $file_change = true;
        }
        if($img = UploadedFile::getInstance($this, 'picture')){
            if($mod->picture !== 'default.jpg' && $mod->picture != null){
                unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/mods/'.$mod->picture);
            }
            $mod->trailer = null;
            $mod->picture = $mod->id.'.'.$img->extension;
            $img->saveAs($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/mods/'.$mod->picture);
            $pic_change = true;
        }
        return $mod->update() == 1 || $pic_change || $file_change;
    }

    private function transliterate($str){
        $ru = ['а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '',  'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

            ' ' => '_'];

        return strtr($str, $ru);

    }

}