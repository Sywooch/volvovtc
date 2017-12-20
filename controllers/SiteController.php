<?php

namespace app\controllers;

use app\models\AddModForm;
use app\models\FiredForm;
use app\models\Mail;
use app\models\MemberForm;
use app\models\Mods;
use app\models\ModsCategories;
use app\models\ModsSubcategories;
use app\models\NicknameForm;
use app\models\Notifications;
use app\models\Other;
use app\models\Recaptcha;
use app\models\Steam;
use app\models\TruckersMP;
use app\models\VacationForm;
use app\models\ResetForm;
use app\models\Trailers;
use app\models\TrailersForm;
use Yii;
use app\models\AddConvoyForm;
use app\models\AddNewsForm;
use app\models\ClaimsFired;
use app\models\ClaimsNickname;
use app\models\ClaimsRecruit;
use app\models\ClaimsVacation;
use app\models\Convoys;
use app\models\News;
use app\models\RecruitForm;
use app\models\SignupForm;
use app\models\ProfileForm;
use app\models\User;
use app\models\VtcMembers;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SiteController extends Controller{

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
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
        return $this->render('index');
    }

    public function actionNotifications(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->request->get('ajax-action') == 'mark_notifications'){
                foreach (Yii::$app->request->post('id') as $id){
                    if(!Notifications::markNotification($id)){
                        return [
                            'status' => 'Error'
                        ];
                    }
                }
                return [
                    'status' => 'OK'
                ];
            }
            if(Yii::$app->request->get('ajax-action') == 'delete_notification'){
                if(!Notifications::deleteNotification(Yii::$app->request->post('id'))){
                    return [
                        'status' => 'Error'
                    ];
                }
                return [
                    'status' => 'OK'
                ];
            }
        }
        return $this->render('error');
    }

    public function actionRules(){
        $edit = false;
        $errors = array();
        if(Yii::$app->request->get('action') == 'edit' && User::isAdmin()){
            if(Yii::$app->request->post('rules')){
                if(Other::updateRules(Yii::$app->request->post('rules'))){
                    if(Yii::$app->request->post('notify') == '1'){
                        Notifications::addNotificationsToMembers('Новые изменения в правилах ВТК!');
                    }
                    return $this->redirect(['site/rules']);
                }
                else $errors[] = 'Ошибка при сохранении!';
            }
            $edit = true;
        }
        $rules = Other::findOne(['category' => 'rules']);
        return $this->render('rules', [
            'rules' => $rules,
            'edit' => $edit,
            'errors' => $errors
        ]);
    }

    public function actionVariations(){
        return $this->render(Yii::$app->request->get('game') == 'ats' ? 'variations_ats' : 'variations_ets');
    }
    
    public function actionNews(){

        // adding images by ajax
        if(Yii::$app->request->isAjax){
            if(Yii::$app->request->get('ajax-action') == 'upload-news-img'){
                Yii::$app->response->format = Response::FORMAT_JSON;
                if($data = News::addAjaxImage($_FILES[0])){
                    return [
                        'status' => 'OK',
                        'file' => $data,
                        't' => time()
                    ];
                }else{
                    return [
                        'status' => 'Error'
                    ];
                }
            }
        }

        // handling add news
        if(Yii::$app->request->get('action') == 'add'){
            // if admin
            if(User::isAdmin()){
                $model = new AddNewsForm();
                $errors = array();
                if($model->load(Yii::$app->request->post()) && $model->validate()){
                    if($id = $model->addNews(Yii::$app->request->post('picture'))){
                        return $this->redirect(['site/news', 'id' => $id]);
                    }else{
                        $errors[] = 'Ошибка при добавлении';
                    }
                }
                return $this->render('add_news', [
                    'model' => $model,
                    'errors' => $errors,
                ]);
            }else{
                return $this->render('error');
            }
        }

        // handling edit news
        if(Yii::$app->request->get('action') == 'edit' && $id = Yii::$app->request->get('id')){
            // if admin
            if(User::isAdmin()){
                $model = new AddNewsForm($id);
                $errors = array();
                if($model->load(Yii::$app->request->post()) && $model->validate()){
                    if(!$model->editNews($id, Yii::$app->request->post('picture'))){
                        $errors[] = 'Ошибка при редактировании';
                    }else{
                        return $this->redirect(['site/news', 'id' => $id]);
                    }
                }else{
                    return $this->render('add_news', [
                        'model' => $model,
                        'errors' => $errors,
                    ]);
                }
            }else{
                return $this->render('error');
            }
        }

        // handling news visibility
        if((Yii::$app->request->get('action') == 'show' || Yii::$app->request->get('action') == 'hide')
            && $id = Yii::$app->request->get('id')){
            if(News::visibleNews($id)){
                return $this->redirect(['site/news']);
            }else{
                $this->redirect(['site/news', 'id' => $id]);
                $errors[] = 'Возникла ошибка';
            }
        }

        // handling deleting news
        if(Yii::$app->request->get('action') == 'delete' && $id = Yii::$app->request->get('id')){
            if(News::deleteNews($id)){
                return $this->redirect(['site/news']);
            }else{
                $this->redirect(['site/news', 'id' => $id]);
                $errors[] = 'Возникла ошибка';
            }
        }

        // handling resorting news
        if((Yii::$app->request->get('action') == 'sortup' || Yii::$app->request->get('action') == 'sortdown')
            && $id = Yii::$app->request->get('id')){
            if(News::resortNews($id)){
                return $this->redirect(['site/news']);
            }else{
                $this->redirect(['site/news']);
                $errors[] = 'Возникла ошибка';
            }
        }

        // displaying exact news
        if(Yii::$app->request->get('id') && !Yii::$app->request->get('action')) {
            if(!$news = News::findOne(Yii::$app->request->get('id'))) return $this->render('error');
            return $this->render('one_news', [
                'news' => $news
            ]);
        }

        // displaying all news
        else{
            if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1){
                $query = News::find();
            }else{
                $query = News::find()->where(['visible' => '1']);
            }
            $pagination = new Pagination([
                'defaultPageSize' => 5,
                'totalCount' => $query->count()
            ]);
            $news = $query->orderBy(['sort' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();
            return $this->render('news', [
                'news' => $news,
                'currentPage' => Yii::$app->request->get('page', 1),
                'totalPages' => $pagination->getPageCount(),
                'pagination' => $pagination
            ]);
        }
    }
    
    public function actionRecruit(){
        if(!Yii::$app->user->isGuest){
            $model = new RecruitForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->addClaim()) return $this->redirect(['site/claims']);
            }
            $rules = '';
            $step = Yii::$app->request->get('step');
            if($step == '2') $rules = Other::findOne(['category' => 'rules']);
            return $this->render('recruit', [
                'model' => $model,
                'step' => $step == '' || $step > 3 ? '1' : $step,
                'rules' => $rules
            ]);
        }else{
            return $this->redirect(['site/login']);
        }
    }

    public function actionSignup(){
        if(Yii::$app->request->isAjax && Yii::$app->request->get('ajax-action') == 'get_truckersmpid'){
            $steam_id = Steam::getUser64ID(Yii::$app->request->post('steam_url'));
            $id = TruckersMP::getUserID($steam_id);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => 'OK',
                'steamid' => $steam_id,
                'url' => 'https://truckersmp.com/user/'. $id .'/'
            ];
        }
        if(!Yii::$app->user->isGuest){
            return $this->redirect(['site/profile', 'id' => Yii::$app->user->id]);
        }
        $model = new SignupForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if(Recaptcha::verifyCaptcha(Yii::$app->request->post('g-recaptcha-response'))){
                if($id = $model->signup()){
                    Yii::$app->user->login(User::findByUsername($model->username));
                    return $this->redirect(['site/profile', 'id' => $id]);
                }else{
                    $model->addError('attr', 'Ошибка при регистрации');
                }
            }else{
                $model->addError('attr', 'Капча не верифицирована!');
            }
        }
        return $this->render('signup', [
            'model' => $model
        ]);
    }
    
    public function actionLogin(){
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/profile', 'id' => Yii::$app->user->id]);
        }
        if(Yii::$app->request->isAjax && Yii::$app->request->get('ajax-action') == 'reset_password'){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $string = User::generatePasswordResetString(Yii::$app->request->post('email'));
            $mailed = $string && Mail::sendResetPassword($string, Yii::$app->request->post('email')) ? 'OK' : 'Error';
            return [
                'status' => $mailed,
            ];
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())){
            $model->attributes = Yii::$app->request->post();
            if($model->validate()){
                $model->login();
                return $this->goBack();
            }
        }
        return $this->render('login', [
            'model' => $model
        ]);
    }
    
    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }
    
    public function actionProfile(){
        $model = new ProfileForm();
        $edit = false;
        $member = false;
        if(Yii::$app->request->isAjax){
            $action = Yii::$app->request->get('ajax-action');
            if($action == 'upload-profile-img'){
                if($path = ProfileForm::updateImage(Yii::$app->user->id, $_FILES[0])) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return [
                        'status' => 'OK',
                        'path' => $path,
                        't' => time()
                    ];
                }
            }
            if($action == 'upload-bg-img'){
                if($path = ProfileForm::updateBgImage(Yii::$app->user->id, $_FILES[0])) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return [
                        'status' => 'OK',
                        'path' => $path,
                        't' => time()
                    ];
                }
            }
            return false;
        }
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            if(VtcMembers::find()->where(['user_id' => $user->id])->one() != null) $member = true;
        }else if(!Yii::$app->request->get('id')){
            return $this->redirect(['site/login']);
        }
        if(Yii::$app->request->get('action') === 'edit'){
            $model->has_ats = $user->has_ats == '1';
            $model->has_ets = $user->has_ets == '1';
            $model->visible_truckersmp = $user->visible_truckersmp == '1';
            $edit = true;
        }
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->editProfile()){
                return $this->redirect(['site/profile']);
            }else{
                $model->addError('attribute', 'Возникла ошибка');
            }
        }
        $id = Yii::$app->user->id;
        if(Yii::$app->request->get('id')) $id = Yii::$app->request->get('id');
        if(!$user = User::findIdentity($id)){
            return $this->goBack();
        }
        $user->age = User::getUserAge($user->birth_date);
        //$user->birth_date = self::getRuDate($user->birth_date);
        return $this->render($edit ? 'edit_profile' : 'profile', [
            'user' => $user,
            'member' => $member,
            'model' => $model
        ]);
    }

    public function actionUsers(){
        if(User::isAdmin()){
            $query = User::find();
            if(Yii::$app->request->get('q')){
                $q = Yii::$app->request->get('q');
                $query->where(['like', 'first_name', $q])
                    ->orWhere(['like', 'last_name', $q])
                    ->orWhere(['like', 'nickname', $q])
                    ->orWhere(['like', 'company', $q])
                    ->orWhere(['like', 'company', $q]);
            }
            $total = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $total
            ]);
            $users = $query->orderBy(['id' => SORT_DESC])->offset($pagination->offset)->limit($pagination->limit)->all();
            return $this->render('users', [
                'users' => $users,
                'currentPage' => Yii::$app->request->get('page', 1),
                'totalPages' => $pagination->getPageCount(),
                'pagination' => $pagination,
                'total' => $total
            ]);
        }else{
            return $this->redirect(['site/error']);
        }
    }

    public function actionReset(){
        if(Yii::$app->request->get('u')) {
            $user = User::findOne(['password_reset' => Yii::$app->request->get('u')]);
            if($user) {
                $model = new ResetForm();
                if($model->load(Yii::$app->request->post()) && $model->validate()) {
                    if($model->saveNewPassword(Yii::$app->request->get('u'))) {
                        return $this->redirect(['site/login']);
                    }
                }
                return $this->render('reset', [
                    'model' => $model
                ]);
            }
        }
        return $this->render('error');
    }

    public static function getRuDate($date){
        if($date != '0000-00-00' && $date != null){
            $month = [
                '01' => 'января',
                '02' => 'февраля',
                '03' => 'марта',
                '04' => 'апреля',
                '05' => 'мая',
                '06' => 'июня',
                '07' => 'июля',
                '08' => 'августа',
                '09' => 'сентября',
                '10' => 'октября',
                '11' => 'ноября',
                '12' => 'декабря'
            ];
            $fdate = new \DateTime($date);
            return $fdate->format('j') . ' ' . $month[$fdate->format('m')] . ' ' . $fdate->format('Y') . 'г.';
        }else{
            return false;
        }
    }

}