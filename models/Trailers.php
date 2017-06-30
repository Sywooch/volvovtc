<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Trailers extends ActiveRecord{

    public static function deleteTrailer($id){
        $trailer = Trailers::findOne($id);
        if($trailer->picture && file_exists(Yii::$app->request->baseUrl).'/web/images/trailers/'.$trailer->picture){
            unlink($_SERVER['DOCUMENT_ROOT'].Yii::$app->request->baseUrl.'/web/images/trailers/'.$trailer->picture);
        }
        return $trailer->delete();
    }

}
