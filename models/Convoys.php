<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Convoys extends ActiveRecord{

    public static function tableName(){
        return 'convoys';
    }

    public function rules(){
        return [
            [['time', 'date'], 'safe'],
            [['truck_var', 'visible', 'open', 'trailer'], 'integer'],
            [['picture_full', 'picture_small', 'start_city', 'start_company', 'finish_city', 'finish_company', 'trailer_name', 'extra_picture'], 'string', 'max' => 255],
            [['rest'], 'string', 'max' => 1024],
            [['description'], 'string', 'max' => 2048],
            [['server', 'trailer_picture'], 'string', 'max' => 45],
            [['length'], 'string', 'max' => 10],
            [['dlc'], 'string']
        ];
    }

    public static function deleteConvoy($id){
        $convoy = Convoys::findOne($id);
        if($convoy->picture_full && file_exists(Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_full)) {
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_full);
        }
        if($convoy->picture_small && file_exists(Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_small)) {
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->picture_small);
        }
        if($convoy->extra_picture && file_exists(Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->extra_picture)) {
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/convoys/'.$convoy->extra_picture);
        }
        return $convoy->delete();
    }

    public static function visibleConvoy($id){
        $convoy = Convoys::findOne($id);
        $convoy->visible = Yii::$app->request->get('action') == 'show' ? '1' : '0';
        return $convoy->update() == 1 ? true : false;
    }

    public static function getSeverName($short){
        switch ($short){
            case 'eu1' : $server = 'Европа 1'; break;
            case 'eu2_ats' : $server = 'Европа 2 - ATS'; break;
            case 'eu3' : $server = 'Европа 3'; break;
            case 'eu5' : $server = 'Европа 5'; break;
            case 'us_ets' : $server = 'United States - ETS2'; break;
            case 'us_ats' : $server = 'United States - ATS'; break;
            case 'hk' : $server = 'Honk Kong'; break;
            case 'sa' : $server = 'South America'; break;
            case 'eu2_ets' :
            default: $server = 'Европа 2 - ETS2'; break;
        }
        return $server;
    }

    public static function getVariationName($short){
        switch ($short){
            case '0' : $variation = 'Любая вариация'; break;
            case '5' : $variation = 'Кастомный тягач'; break;
            case '4' : $variation = 'Вариация №1 или №3'; break;
            case '3' : $variation = 'Вариация №3'; break;
            case '2' : $variation = 'Вариация №2'; break;
            case '1' :
            default: $variation = 'Вариация №1'; break;
        }
        return $variation;
    }

    public static function getDLCString($dlc){
        $need = false;
        $string = '<i class="material-icons left" style="font-size: 22px">warning</i>Для участия необходимо ';
        foreach ($dlc as $key => $item){
            if($item == '1'){
                $string .= 'DLC '.$key.', ';
                $need = true;
            }
        }
        return $need ? substr($string, 0, strlen($string) - 2) : false;
    }

    public static function getTrailerData($convoy){
        $description = '';
        $name = '';
        $image = 'trailers/default.jpg';
        if($convoy->trailer != 0 && $convoy->trailer != -1) {
            $trailer = \app\models\Trailers::findOne($convoy->trailer);
            $image = 'trailers/'.$trailer->picture;
            $name = $trailer->name;
            $description = $trailer->description;
        }
        return [
            'image' => $image,
            'name' => $name,
            'description' => $description,
        ];
    }

}
