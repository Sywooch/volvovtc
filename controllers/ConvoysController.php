<?php

namespace app\controllers;

use app\models\AddConvoyForm;
use app\models\Convoys;
use app\models\Mods;
use app\models\Notifications;
use app\models\Trailers;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ConvoysController extends Controller{

    public function actions(){
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    public function beforeAction($action){
        // getting user notifications
        if(!Yii::$app->user->isGuest){
            // online
            User::setUserActivity(Yii::$app->user->id);

            // notifications
            $has_unread = false;
            $notifications = Notifications::find()
                ->where(['uid' => Yii::$app->user->id])
                ->orderBy(['date' => SORT_DESC, 'status' => SORT_ASC])
                ->all();
            foreach ($notifications as $notification){
                if($notification->status == '0') {
                    $has_unread = true;
                    break;
                }
            }
            Yii::$app->view->params['notifications'] = $notifications;
            Yii::$app->view->params['hasUnreadNotifications'] = $has_unread;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        if(Yii::$app->request->get('id')){
            if(!$convoy = Convoys::findOne(Yii::$app->request->get('id'))) return $this->render('error');
            if($convoy->open == '0' && !User::isVtcMember()) return $this->redirect(['site/login']);
            $convoy->server = Convoys::getSeverName($convoy->server);
            $convoy->truck_var = Convoys::getVariationName($convoy->truck_var);
            $convoy->date = SiteController::getRuDate($convoy->date);
            return $this->render('convoy', [
                'convoy' => $convoy,
                'mod' => Mods::getModByTrailer($convoy->trailer)
            ]);
        }else{
            return $this->render('index', [
                'convoys' => Convoys::getFutureConvoys(),
                'nearest_convoy' => Convoys::getNearestConvoy(),
                'hidden_convoys' => Convoys::getPastConvoys()
            ]);
        }
    }

    public function actionAdd(){
        if(User::isAdmin()){
            $model = new AddConvoyForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($id = $model->addConvoy()){
                    return $this->redirect(['convoys/index', 'id' => $id]);
                }else{
                    $errors[] = 'Ошибка при добавлении';
                }
            }
            return $this->render('add_convoy', [
                'model' => $model,
                'trailers' => Trailers::getTrailers(['0' => 'Любой прицеп', '-1' => 'Без прицепа'])
            ]);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionEdit(){
        if(User::isAdmin() && Yii::$app->request->get('id')){
            $model = new AddConvoyForm(Yii::$app->request->get('id'));
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if(!$model->editConvoy(Yii::$app->request->get('id'))){
                    $errors[] = 'Ошибка при редактировании';
                }
                return $this->redirect(['convoys/index', 'id' => Yii::$app->request->get('id')]);
            }else{
                return $this->render('edit_convoy', [
                    'model' => $model,
                    'trailers' => Trailers::getTrailers(['0' => 'Любой прицеп', '-1' => 'Без прицепа']),
                    'trailer_data' => Convoys::getTrailerData($model)
                ]);
            }
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionRemove(){
        if(User::isAdmin() && Yii::$app->request->get('id')){
            if(Convoys::deleteConvoy(Yii::$app->request->get('id'))){
                return $this->redirect(['convoys/index']);
            }else{
                $errors[] = 'Возникла ошибка';
            }
            return $this->redirect(['convoys/index', 'id' => Yii::$app->request->get('id')]);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionTrailer(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->request->post('id')) {
                if($trailer = Trailers::findOne(Yii::$app->request->post('id'))){
                    return [
                        'name' => $trailer->name,
                        'description' => $trailer->description,
                        'image' => $trailer->picture,
                        'status' => 'OK'
                    ];
                }
            }
            return [
                'status' => 'Error'
            ];
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionHide(){
        if(User::isAdmin() && Yii::$app->request->get('id')){
            Convoys::visibleConvoy(Yii::$app->request->get('id'), 'hide');
            return $this->redirect(['convoys/index']);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionShow(){
        if(User::isAdmin() && Yii::$app->request->get('id')){
            Convoys::visibleConvoy(Yii::$app->request->get('id'), 'show');
            return $this->redirect(['convoys/index']);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionDeleteextrapicture(){
        if(User::isAdmin() && Yii::$app->request->get('id')){
            Convoys::deleteExtraPicture(Yii::$app->request->get('id'));
            return $this->redirect(['convoys/edit', 'id' => Yii::$app->request->get('id')]);
        }else{
            return $this->render('//site/error');
        }
    }

}