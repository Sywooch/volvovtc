<?php

namespace app\controllers;

use app\models\Achievements;
use app\models\AchievementsProgress;
use app\models\MemberForm;
use app\models\Notifications;
use app\models\User;
use app\models\VtcMembers;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class MembersController extends Controller{

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
        return $this->render('index', [
            'all_members' => VtcMembers::getAllMembers()
        ]);
    }

    public function actionStats(){
        VtcMembers::cleanVacations();
        return $this->render('stats', [
            'all_members' => VtcMembers::getMembers(false)
        ]);
    }

    public function actionEdit(){
        if(Yii::$app->request->get('id') && User::isAdmin()){
            $model = new MemberForm(Yii::$app->request->get('id'));
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->editMember(Yii::$app->request->get('id'))){
                    return $this->redirect(['members/edit', 'id' => Yii::$app->request->get('id')]);
                }
            }
            return $this->render('edit', [
                'model' => $model,
                'all_achievements' => Achievements::find()->all(),
                'achievements_progress' => AchievementsProgress::find()
                    ->select(['ach_id'])
                    ->where(['uid' => $model->user_id, 'complete' => 1])
                    ->asArray()
                    ->all()
            ]);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionReset(){
        VtcMembers::zeroScores();
        return $this->redirect(['members/stats']);
    }

    public function actionDismiss(){
        if(Yii::$app->request->get('id') && User::isAdmin()){
            VtcMembers::fireMember(Yii::$app->request->get('id'));
            return $this->redirect(['members/stats']);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionScores(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->request->post('id') && Yii::$app->request->post('scores') && Yii::$app->request->post('target')){
                if($result = VtcMembers::addScores(Yii::$app->request->post('id'), Yii::$app->request->post('scores'), Yii::$app->request->post('target'))){
                    return [
                        'status' => 'OK',
                        'scores' => $result
                    ];
                }else{
                    return [
                        'status' => 'Error while adding scores',
                    ];
                }
            }else{
                return [
                    'status' => 'Error, check data',
                ];
            }
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionGetbans() {
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->request->post('steamid64')){
                return [
                    'bans' => VtcMembers::getBans(Yii::$app->request->post('steamid64')),
                    'status' => 'OK'
                ];
            }
            return [
                'status' => 'Error, no Steam IDs to check'
            ];
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionResort(){
        if(Yii::$app->request->get('id') && User::isAdmin()
            && (Yii::$app->request->get('dir') == 'down' || Yii::$app->request->get('dir') == 'up')){
            VtcMembers::resortMembers(Yii::$app->request->get('id'));
            return $this->redirect(['members/index']);
        }else{
            return $this->render('//site/error');
        }
    }

}