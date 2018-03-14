<?php

namespace app\controllers;

use app\models\AchievementsProgress;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
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
        if(!Yii::$app->request->isAjax){
			if(Yii::$app->user->isGuest){
				return $this->redirect(['site/login']);
			}
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
            $user_ach_progress = AchievementsProgress::find()->select(['ach_id'])->where(['uid' => Yii::$app->user->id, 'complete' => 1])->asArray()->all();
            $total = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => 15,
                'totalCount' => $total
            ]);
            $moderate_count = 0;
            if(User::isAdmin()){
                $moderate_count = AchievementsProgress::find()->where(['complete' => 0])->count();
            }
            return $this->render('index', [
                'achievements' => $query->orderBy(['sort' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all(),
                'user_complete_ach' => unserialize(Yii::$app->user->identity->achievements),
                'user_ach_progress' => $user_ach_progress,
                'currentPage' => Yii::$app->request->get('page', 1),
                'totalPages' => $pagination->getPageCount(),
                'pagination' => $pagination,
                'total' => $total,
                'moderate_count' => $moderate_count
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
            $query = AchievementsProgress::find()
				->select([
						'achievements_progress.id',
						'achievements_progress.ach_id',
						'achievements_progress.uid',
						'achievements_progress.proof',
						'achievements_progress.complete',
						'achievements.title',
						'achievements.description',
						'achievements.image',
						'users.company as u_company',
						'users.nickname as u_nickname'
					])
				->innerJoin('achievements', 'achievements_progress.ach_id = achievements.id')
				->innerJoin('users', 'achievements_progress.uid = users.id');
            $total = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $total
            ]);
            $progress = $query->orderBy([
					'achievements_progress.complete' => SORT_ASC,
					'achievements_progress.id' => SORT_DESC
				])
				->offset($pagination->offset)->limit($pagination->limit)->all();
            return $this->render('moderate_achievements', [
                'progress' => $progress,
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