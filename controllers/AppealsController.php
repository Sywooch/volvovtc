<?php

namespace app\controllers;

use app\models\AppealForm;
use app\models\Appeals;
use app\models\Notifications;
use app\models\User;
use app\models\VtcMembers;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class AppealsController extends Controller{

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
        if(User::isAdmin()){
            $query = Appeals::find()->orderBy(['date' => SORT_DESC]);
            $total = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $total
            ]);
            $appeals = $query->offset($pagination->offset)->limit($pagination->limit)->all();
            foreach ($appeals as $appeal){
                $appeal->appealed_member = VtcMembers::findOne($appeal->appeal_to_id);
                $appeal->appealed_user = User::findOne($appeal->appeal_to_user_id);
                $appeal->from_user = User::findOne($appeal->uid);
            }
            return $this->render('index', [
                'appeals' => $appeals,
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
        $model = new AppealForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->addAppeal()) return $this->redirect(['appeals/thx']);
            else $model->addError('uid', 'Возникла ошибка');
        }
        return $this->render('add', [
            'model' => $model,
            'members' => array_replace(['' => 'Выберите сотрудника'], VtcMembers::getMembersArray())
        ]);
    }

    public function actionThx(){
        return $this->render('thx');
    }

    public function actionViewed(){
        if(User::isAdmin()){
            Appeals::viewedAppeal(Yii::$app->request->get('id'));
            return $this->redirect(['appeals/index']);
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionRemove(){
        if(User::isAdmin()){
            Appeals::removeAppeal(Yii::$app->request->get('id'));
            return $this->redirect(['appeals/index']);
        }else{
            return $this->render('//site/error');
        }
    }

}