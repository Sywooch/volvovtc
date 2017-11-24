<?php

namespace app\controllers;

use app\models\AchievementsProgress;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\models\User;
use app\models\Notifications;
use app\models\Achievements;
use app\models\AchievementsForm;
use yii\web\Response;

class AchievementsController extends Controller{

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
        if(User::isVtcMember()){
            $query = Achievements::find();
            if(!User::isAdmin()) $query = $query->where(['visible' => '1']);
            if(Yii::$app->request->get('q')){
                $q = Yii::$app->request->get('q');
                $query->where(['like', 'title', $q])
                    ->orWhere(['like', 'description', $q]);
            }
            $user_complete_ach = User::find()->select(['achievements'])->where(['id' => Yii::$app->user->id])->one();
            $user_ach_progress = AchievementsProgress::find()->select(['ach_id'])->where(['uid' => Yii::$app->user->id, 'complete' => 1])->asArray()->all();
            $total = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => 15,
                'totalCount' => $total
            ]);
            return $this->render('index', [
                'achievements' => $query->orderBy(['sort' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all(),
                'user_complete_ach' => unserialize($user_complete_ach->achievements),
                'user_ach_progress' => $user_ach_progress,
                'currentPage' => Yii::$app->request->get('page', 1),
                'totalPages' => $pagination->getPageCount(),
                'pagination' => $pagination,
                'total' => $total,
            ]);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionAdd(){
        if(User::isAdmin()){
            $model = new AchievementsForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->addAchievement()){
                    return $this->redirect(['index']);
                }else{
                    $model->addError('title', 'Возникла ошибка');
                }
            }
            return $this->render('add_achievement', [
                'model' => $model,
                'related' => ArrayHelper::map(Achievements::find()->asArray()->all(), 'id', 'title')
            ]);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionEdit(){
        if(User::isAdmin()){
            $model = new AchievementsForm(Yii::$app->request->get('id'));
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->editAchievement(Yii::$app->request->get('id'))){
                    return $this->redirect(['index']);
                }else{
                    $model->addError('title', 'Возникла ошибка');
                }
            }
            return $this->render('add_achievement', [
                'model' => $model,
                'related' => ArrayHelper::map(Achievements::find()->asArray()->all(), 'id', 'title')
            ]);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionRemove(){
        if(User::isAdmin()){
            Achievements::removeAchievement(Yii::$app->request->get('id'));
            return $this->redirect(['achievements/index']);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionSort(){
        if(User::isAdmin()){
            Achievements::resortAchievement(Yii::$app->request->get('id'), Yii::$app->request->get('operation'));
            return $this->redirect(['achievements/index']);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionGet(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => AchievementsProgress::getAchievement(Yii::$app->user->id, Yii::$app->request->get('achid'), $_FILES[0]) ? 'OK' : 'Error',
                'files' => $_FILES[0],
            ];
        }else{
            return false;
        }
    }

    public function actionModerate(){
        if(User::isAdmin()){
            $achievements = Achievements::find()->asArray()->all();
            $new_achievements = array();
            foreach ($achievements as $achievement) {
                $new_achievements[$achievement['id']]['title'] = $achievement['title'];
                $new_achievements[$achievement['id']]['description'] = $achievement['description'];
                $new_achievements[$achievement['id']]['image'] = $achievement['image'];
                $new_achievements[$achievement['id']]['visible'] = $achievement['visible'];
                $new_achievements[$achievement['id']]['sort'] = $achievement['sort'];
            }
            $query = AchievementsProgress::find();
            $total = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $total
            ]);
            $progress = $query->orderBy(['complete' => SORT_ASC, 'id' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();
            $count = 0;
            foreach($progress as $item){
                $item->uid = User::findOne($item->uid);
                if($item->complete == 0) $count++;
            }
            return $this->render('moderate_achievements', [
                'progress' => $progress,
                'count' => $count,
                'achievements' => $new_achievements,
                'currentPage' => Yii::$app->request->get('page', 1),
                'totalPages' => $pagination->getPageCount(),
                'pagination' => $pagination,
                'total' => $total
            ]);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionApply(){
        if(User::isAdmin() && Yii::$app->request->get('id')){
            AchievementsProgress::applyAchievement(Yii::$app->request->get('id'));
            return $this->redirect(['achievements/moderate']);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionDeny(){
        if(User::isAdmin() && Yii::$app->request->get('id')){
            AchievementsProgress::denyAchievement(Yii::$app->request->get('id'));
            return $this->redirect(['achievements/moderate']);
        }else{
            return $this->render('//site/error');
        }
    }

}