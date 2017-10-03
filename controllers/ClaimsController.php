<?php

namespace app\controllers;

use app\models\ClaimsFired;
use app\models\ClaimsNickname;
use app\models\ClaimsRecruit;
use app\models\ClaimsVacation;
use app\models\FiredForm;
use app\models\NicknameForm;
use app\models\Notifications;
use app\models\RecruitForm;
use app\models\User;
use app\models\VacationForm;
use app\models\VtcMembers;
use Yii;
use yii\web\Controller;

class ClaimsController extends Controller{

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
        $recruits = ClaimsRecruit::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();
        $fired = ClaimsFired::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();
        $vacation = ClaimsVacation::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();
        $nickname = ClaimsNickname::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();
        return $this->render('index', [
            'recruits' => $recruits,
            'fired' => $fired,
            'vacation' => $vacation,
            'nickname' => $nickname
        ]);
    }

    public function actionAdd(){
        if(Yii::$app->request->get('claim')){
            $claim = Yii::$app->request->get('claim');
            switch(Yii::$app->request->get('claim')){
                case 'recruit' : {
                    return $this->redirect(['site/recruit']);
                    break;
                }
                case 'dismissal' : {
                    $form = new FiredForm();
                    $render = 'add_fired_claim';
                    break;
                }
                case 'nickname' : {
                    $form = new NicknameForm();
                    $render = 'add_nickname_claim';
                    break;
                }
                case 'vacation' :
                default : {
                    $form = new VacationForm();
                    $render = 'add_vacation_claim';
                    break;
                }
            }
            if($form->load(Yii::$app->request->post()) && $form->validate()) {
                if($form->addClaim()){
                    return $this->redirect(['claims/index', '#' => $claim]);
                }else{
                    $form->addError('id','Возникла ошибка');
                }
            }
            if(User::isVtcMember()){
                return $this->render($render, [
                    'model' => $form
                ]);
            }else{
                return $this->redirect(['claims/index', '#' => $claim]);
            }
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionEdit(){
        if(Yii::$app->request->get('claim') && Yii::$app->request->get('id') && !Yii::$app->user->isGuest){
            $id = Yii::$app->request->get('id');
            switch(Yii::$app->request->get('claim')){
                case 'recruit' : {
                    $form = new RecruitForm($id);
                    $claim = ClaimsRecruit::findOne($id);
                    $render = 'edit_recruit_claim';
                    break;
                }
                case 'dismissal' : {
                    $form = new FiredForm($id);
                    $claim = ClaimsFired::findOne($id);
                    $render = 'edit_fired_claim';
                    break;
                }
                case 'nickname' : {
                    $form = new NicknameForm($id);
                    $claim = ClaimsNickname::findOne($id);
                    $render = 'edit_nickname_claim';
                    break;
                }
                case 'vacation' :
                default: {
                    $form = new VacationForm($id);
                    $claim = ClaimsVacation::findOne($id);
                $render = 'edit_vacation_claim';
                    break;
                }
            }
            if($form->load(Yii::$app->request->post()) && $form->validate()) {
                if($result = $form->editClaim($id)){
                    return $this->redirect(['claims/index', '#' => Yii::$app->request->get('claim')]);
                }else{
                    $form->addError('id','Возникла ошибка');
                }
            }
            // if admin or (claim id = user id and status = 0)
            $user = User::findIdentity($claim->user_id);
            if(($user->id == $claim->user_id && $claim->status == '0') || User::isAdmin()){
                $user = User::findIdentity($claim->user_id);
                return $this->render($render, [
                    'model' => $form,
                    'claim' => $claim,
                    'user' => $user,
                    'viewed' => User::find()->select('first_name, last_name')->where(['id' => $form->viewed])->one()
                ]);
            }else{
                return $this->redirect(['claims/index', '#' => Yii::$app->request->get('claim')]);
            }
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionApply(){
        if(Yii::$app->request->get('claim') && Yii::$app->request->get('id')){
            switch(Yii::$app->request->get('claim')){
                case 'recruit' : {
                    RecruitForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['claims/index', '#' => 'recruit']);
                    break;
                }
                case 'dismissal' : {
                    FiredForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['claims/index', '#' => 'dismissal']);
                    break;
                }
                case 'nickname' : {
                    NicknameForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['claims/index', '#' => 'nickname']);
                    break;
                }
                case 'vacation' :
                default : {
                    VacationForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['claims/index', '#' => 'vacation']);
                    break;
                }
            }
        }else{
            return $this->render('//site/error');
        }
    }

    public function actionRemove(){
        if(User::isAdmin() && Yii::$app->request->get('claim') && Yii::$app->request->get('id')){
            $id = Yii::$app->request->get('id');
            switch(Yii::$app->request->get('claim')){
                case 'recruit' :
                    RecruitForm::deleteClaim($id);
                    return $this->redirect(['claims/index', '#' => 'recruit']);
                    break;
                case 'dismissal' :
                    FiredForm::deleteClaim($id);
                    return $this->redirect(['claims/index', '#' => 'dismissal']);
                    break;
                case 'nickname' :
                    NicknameForm::deleteClaim($id);
                    return $this->redirect(['claims/index', '#' => 'nickname']);
                    break;
                case 'vacation' :
                default :
                    VacationForm::deleteClaim($id);
                    return $this->redirect(['claims/index', '#' => 'vacation']);
                    break;
            }
        }else{
            return $this->render('//site/error');
        }
    }

    public static function countClaims($claims, $status = true){
        if(!$status){
            return count($claims);
        }else{
            $count = 0;
            foreach ($claims as $claim){
                if($claim->status == '0'){
                    $count++;
                }
            }
            return $count;
        }
    }

}