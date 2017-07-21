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
        return $this->render('variations');
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
    
    public function actionConvoys(){

        // handling ajax
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->request->post('action') == 'get_trailer') {
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
        }

        // handling add convoy
        if(Yii::$app->request->get('action') == 'add'){
            // if admin
            if(User::isAdmin()){
                $model = new AddConvoyForm();
                if($model->load(Yii::$app->request->post()) && $model->validate()){
                    if($id = $model->addConvoy()){
                        return $this->redirect(['site/convoys', 'id' => $id]);
                    }else{
                        $errors[] = 'Ошибка при добавлении';
                    }
                }
                return $this->render('add_convoy', [
                    'model' => $model,
                    'trailers' => Trailers::getTrailers(['0' => 'Любой прицеп', '-1' => 'Без прицепа'])
                ]);
            }else{
                return $this->render('error');
            }
        }

        // handling edit convoy
        if(Yii::$app->request->get('action') == 'edit' && $id = Yii::$app->request->get('id')){
            // if admin
            if(User::isAdmin()){
                $model = new AddConvoyForm($id);
                if($model->load(Yii::$app->request->post()) && $model->validate()){
                    if(!$model->editConvoy($id)){
                        $errors[] = 'Ошибка при редактировании';
                    }else{
                        return $this->redirect(['site/convoys', 'id' => $id]);
                    }
                }else{
                    return $this->render('edit_convoy', [
                        'model' => $model,
                        'trailers' => Trailers::getTrailers(['0' => 'Любой прицеп', '-1' => 'Без прицепа']),
                        'trailer_data' => Convoys::getTrailerData($model)
                    ]);
                }
            }else{
                return $this->render('error');
            }
        }

        // handling deleting convoy
        if(Yii::$app->request->get('action') == 'delete' && $id = Yii::$app->request->get('id')){
            if(Convoys::deleteConvoy($id)){
                return $this->redirect(['site/convoys']);
            }else{
                $this->redirect(['site/convoys', 'id' => $id]);
                $errors[] = 'Возникла ошибка';
            }
        }

        // handling visibility of convoy
        if((Yii::$app->request->get('action') == 'show' || Yii::$app->request->get('action') == 'hide')
            && $id = Yii::$app->request->get('id')){
            if(Convoys::visibleConvoy($id)){
                return $this->redirect(['site/convoys']);
            }else{
                $this->redirect(['site/convoys', 'id' => $id]);
                $errors[] = 'Возникла ошибка';
            }
        }

        // handling removing extra picture
        if(Yii::$app->request->get('action') == 'delete_extra_picture' && User::isAdmin()){
            if($id = Yii::$app->request->get('id')){
                Convoys::deleteExtraPicture($id);
                return $this->redirect(['site/convoys', 'action' => 'edit', 'id' => $id]);
            }else{
                return false;
            }
        }

        // displaying exact convoy
        if(Yii::$app->request->get('id') && !Yii::$app->request->get('action')){
            if(!$convoy = Convoys::findOne(Yii::$app->request->get('id'))) return $this->render('error');
            if($convoy->open == '0' && !User::isVtcMember()) return $this->redirect(['site/login']);
            $convoy->server = Convoys::getSeverName($convoy->server);
            $convoy->truck_var = Convoys::getVariationName($convoy->truck_var);
            $convoy->date = $this->getRuDate($convoy->date);
            return $this->render('convoy', [
                'convoy' => $convoy,
                'mod' => Mods::getModByTrailer($convoy->trailer)
            ]);
        }

        // displaying all convoys
        else{
            return $this->render('convoys', [
                'convoys' => Convoys::getFutureConvoys(),
                'nearest_convoy' => Convoys::getNearestConvoy(),
                'hidden_convoys' => Convoys::getPastConvoys()
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

    public function actionClaims(){
        $recruits = ClaimsRecruit::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();
        $fired = ClaimsFired::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();
        $vacation = ClaimsVacation::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();
        $nickname = ClaimsNickname::find()->orderBy(['id'=> SORT_DESC])->limit(20)->all();

        // handle deleting claims - if admin only
        if(Yii::$app->request->get('action') == 'delete' && Yii::$app->request->get('id')
                && !Yii::$app->user->isGuest && Yii::$app->user->identity->admin == '1'){
            $id = Yii::$app->request->get('id');
            switch(Yii::$app->request->get('claim')){
                case 'recruit' :
                    if(RecruitForm::deleteRecruitClaim($id)){
                        return $this->redirect(['site/claims']);
                    }
                    break;
                case 'dismissal' :
                    if(FiredForm::deleteFiredClaim($id)){
                        return $this->redirect(['site/claims']);
                    }
                    break;
                case 'nickname' :
                    if(NicknameForm::deleteNicknameClaim($id)){
                        return $this->redirect(['site/claims']);
                    }
                    break;
                case 'vacation' :
                    if(VacationForm::deleteVacationClaim($id)){
                        return $this->redirect(['site/claims']);
                    }
                    break;
            }
        }

        // handle editing claims
        if(Yii::$app->request->get('action') == 'edit' && $id = Yii::$app->request->get('id')){
            switch(Yii::$app->request->get('claim')){
                case 'recruit' : {
                    $recruitForm = new RecruitForm($id);
                    if($recruitForm->load(Yii::$app->request->post()) && $recruitForm->validate()) {
                        if($recruitForm->editRecruitClaim($id)){
                            return $this->redirect(['site/claims']);
                        }
                    }else{
                        $recruitClaim = ClaimsRecruit::findOne($id);
                        // if admin or (claim id = user id and status = 0)
                        if((Yii::$app->user->id == $recruitClaim->user_id && $recruitClaim->status == '0') || User::isAdmin()){
                            $user = User::findIdentity($recruitClaim->user_id);
                            return $this->render('edit_recruit_claim', [
                                'model' => $recruitForm,
                                'claim' => $recruitClaim,
                                'user' => $user,
                                'viewed' => User::find()->select('first_name, last_name')->where(['id' => $recruitForm->viewed])->one()
                            ]);
                        }else{
                            return $this->redirect(['site/claims']);
                        }
                    }
                    break;
                }
                case 'dismissal' : {
                    $firedForm = new FiredForm($id);
                    if($firedForm->load(Yii::$app->request->post()) && $firedForm->validate()) {
                        if($firedForm->editFiredClaim($id)){
                            return $this->redirect(['site/claims']);
                        }
                    }else{
                        $firedClaim = ClaimsFired::findOne($id);
                        // if admin or (claim id = user id and status = 0)
                        $user = VtcMembers::find()->select(['id'])->where(['user_id' => Yii::$app->user->id])->one();
                        if((($user->id == $firedClaim->member_id) && $firedClaim->status == '0')
                            || !Yii::$app->user->isGuest && Yii::$app->user->identity->admin == '1'){
                            $user = User::findIdentity($firedClaim->user_id);
                            return $this->render('edit_fired_claim', [
                                'model' => $firedForm,
                                'claim' => $firedClaim,
                                'user' => $user,
                                'viewed' => User::find()->select('first_name, last_name')->where(['id' => $firedClaim->viewed])->one()
                            ]);
                        }else{
                            return $this->redirect(['site/claims']);
                        }
                    }
                    break;
                }
                case 'nickname' : {
                    $nicknameForm = new NicknameForm($id);
                    if($nicknameForm->load(Yii::$app->request->post()) && $nicknameForm->validate()) {
                        if($nicknameForm->editRecruitClaim($id)){
                            return $this->redirect(['site/claims']);
                        }
                    }else{
                        $nicknameClaim = ClaimsNickname::findOne($id);
                        // if admin or (claim id = user id and status = 0)
                        $user = VtcMembers::find()->select(['id'])->where(['user_id' => Yii::$app->user->id])->one();
                        if(($user->id == $nicknameClaim->member_id && $nicknameClaim->status == '0')
                            || !Yii::$app->user->isGuest && Yii::$app->user->identity->admin == '1'){
                            $user = User::findIdentity($nicknameClaim->user_id);
                            return $this->render('edit_nickname_claim', [
                                'model' => $nicknameForm,
                                'claim' => $nicknameClaim,
                                'user' => $user,
                                'viewed' => User::find()->select('first_name, last_name')->where(['id' => $nicknameForm->viewed])->one()
                            ]);
                        }else{
                            return $this->redirect(['site/claims']);
                        }
                    }
                    break;
                }
                case 'vacation' : {
                    $vacationForm = new VacationForm($id);
                    if($vacationForm->load(Yii::$app->request->post()) && $vacationForm->validate()) {
                        if($result = $vacationForm->editVacationClaim($id)){
                            return $this->redirect(['site/claims']);
                        }
                    }else{
                        $vacationClaim = ClaimsVacation::findOne($id);
                        // if admin or (claim id = user id and status = 0)
                        $user = VtcMembers::find()->select(['id'])->where(['user_id' => Yii::$app->user->id])->one();
                        if(($user->id == $vacationClaim->member_id && $vacationClaim->status == '0')
                            || !Yii::$app->user->isGuest && Yii::$app->user->identity->admin == '1'){
                            $user = User::findIdentity($vacationClaim->user_id);
                            return $this->render('edit_vacation_claim', [
                                'model' => $vacationForm,
                                'claim' => $vacationClaim,
                                'user' => $user,
                                'viewed' => User::find()->select('first_name, last_name')->where(['id' => $vacationForm->viewed])->one()
                            ]);
                        }else{
                            return $this->redirect(['site/claims']);
                        }
                    }
                    break;
                }
            }
        }

        // handle quick apply claims
        if(Yii::$app->request->get('action') == 'apply' && Yii::$app->request->get('id') && User::isAdmin()){
            switch(Yii::$app->request->get('claim')){
                case 'recruit' : {
                    RecruitForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['site/claims']);
                    break;
                }
                case 'dismissal' : {
                    FiredForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['site/claims']);
                    break;
                }
                case 'nickname' : {
                    NicknameForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['site/claims']);
                    break;
                }
                case 'vacation' : {
                    VacationForm::quickClaimApply(Yii::$app->request->get('id'));
                    return $this->redirect(['site/claims']);
                    break;
                }
            }
        }

        // handling adding claim
        if(Yii::$app->request->get('action') == 'add' && Yii::$app->request->get('claim')){
            switch(Yii::$app->request->get('claim')){
                case 'recruit' : {
                    return $this->redirect(['site/recruit']);
                    break;
                }
                case 'dismissal' : {
                    $firedForm = new FiredForm();
                    if($firedForm->load(Yii::$app->request->post()) && $firedForm->validate()) {
                        if($firedForm->addClaim()){
                            return $this->redirect(['site/claims']);
                        }
                    }else{
                        if(VtcMembers::find()->select(['id'])->where(['user_id' => Yii::$app->user->id])->one() != false){
                            return $this->render('add_fired_claim', [
                                'model' => $firedForm
                            ]);
                        }else{
                            return $this->redirect(['site/claims']);
                        }
                    }
                    break;
                }
                case 'nickname' : {
                    $nicknameForm = new NicknameForm();
                    if($nicknameForm->load(Yii::$app->request->post()) && $nicknameForm->validate()) {
                        if($nicknameForm->addClaim()){
                            return $this->redirect(['site/claims']);
                        }
                    }else{
                        if(VtcMembers::find()->where(['user_id' => Yii::$app->user->id])->one() != false){
                            return $this->render('add_nickname_claim', [
                                'model' => $nicknameForm
                            ]);
                        }else{
                            return $this->redirect(['site/claims']);
                        }
                    }
                    break;
                }
                case 'vacation' : {
                    $vacationForm = new VacationForm();
                    if($vacationForm->load(Yii::$app->request->post()) && $vacationForm->validate()) {
                        if($vacationForm->addClaim()){
                            return $this->redirect(['site/claims']);
                        }
                    }else{
                        if(VtcMembers::find()->where(['user_id' => Yii::$app->user->id])->one() != false){
                            return $this->render('add_vacation_claim', [
                                'model' => $vacationForm
                            ]);
                        }else{
                            return $this->redirect(['site/claims']);
                        }
                    }
                    break;
                }
            }
        }

        return $this->render('claims', [
            'recruits' => $recruits,
            'fired' => $fired,
            'vacation' => $vacation,
            'nickname' => $nickname
        ]);
    }
    
    public function actionModifications(){

        // handling ajax
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->request->post('action') == 'get_trailer') {
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
        }

        // handling adding mods - if admin only
        if(Yii::$app->request->get('action') == 'add' && User::isAdmin()){
            $model = new AddModForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->addMod() != false){
                    $cat = explode('/', $model->category);
                    return $this->redirect(['site/modifications', 'game' => $cat[0], 'category' => $cat[1], 'subcategory' => $cat[2]]);
                }
            }
            return $this->render('add_mod', [
                'model' => $model,
                'categories' => ModsCategories::getCatsWithSubCats(),
                'trailers' => Trailers::getTrailers(['0' => 'Нет прицепа']),
            ]);
        }

        // handling editing mods - if admin only
        if(Yii::$app->request->get('action') == 'edit' && Yii::$app->request->get('id') && User::isAdmin()){
            $model = new AddModForm(Yii::$app->request->get('id'));
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->editMod(Yii::$app->request->get('id')) != false){
                    $mod = Mods::findOne(Yii::$app->request->get('id'));
                    return $this->redirect(['site/modifications',
                        'game' => $mod->game,
                        'category' => $mod->category,
                        'subcategory' => $mod->category == $mod->subcategory ? '' : $mod->subcategory
                    ]);
                }
            }
            return $this->render('edit_mod', [
                'model' => $model,
                'categories' => ModsCategories::getCatsWithSubCats(),
                'trailers' => Trailers::getTrailers(['0' => 'Нет прицепа']),
                'trailer_data' => Mods::getTrailerData($model)
            ]);
        }

        // handling visibility mods - if admin only
        if((Yii::$app->request->get('action') == 'show' || Yii::$app->request->get('action') == 'hide')
            && Yii::$app->request->get('id') && User::isAdmin()){
            if(Mods::visibleMod(Yii::$app->request->get('id'))){
                $mod = Mods::findOne(Yii::$app->request->get('id'));
                return $this->redirect(['site/modifications', 'game' => $mod->game, 'category' => $mod->category]);
            }else{
                $errors[] = 'Возникла ошибка';
            }
        }

        // handling deleting mod
        if(Yii::$app->request->get('action') == 'delete' && Yii::$app->request->get('id') && User::isAdmin()){
            $mod = Mods::findOne(Yii::$app->request->get('id'));
            if(Mods::deleteMod(Yii::$app->request->get('id'))){
                return $this->redirect(['site/modifications',
                    'game' => $mod->game,
                    'category' => $mod->category,
                    'subcategory' => $mod->category == $mod->subcategory ? '' : $mod->subcategory
                ]);
            }else{
                $errors[] = 'Возникла ошибка';
            }
        }

        // handling resorting mods
        if((Yii::$app->request->get('action') == 'sortup' || Yii::$app->request->get('action') == 'sortdown')
        && Yii::$app->request->get('id') && User::isAdmin()){
            $mod = Mods::findOne(Yii::$app->request->get('id'));
            if(Mods::resortMod(Yii::$app->request->get('id'))){
                return $this->redirect(['site/modifications', 'game' => $mod->game, 'category' => $mod->category, 'subcategory' => $mod->subcategory]);
            }else{
                $errors[] = 'Возникла ошибка';
            }
        }

        // displaying category/subcategory
        if(Yii::$app->request->get('game') && Yii::$app->request->get('category')){
            $game = Yii::$app->request->get('game');
            $category = Yii::$app->request->get('category');
            $subcategory = Yii::$app->request->get('subcategory') ? Yii::$app->request->get('subcategory') : Yii::$app->request->get('category');
            $mods = Mods::find()->where(['game' => $game, 'category' => $category, 'subcategory' => $subcategory])->orderBy(['sort' => SORT_DESC])->all();
            $category = ModsCategories::findOne(['name' => $category, 'game' => $game]);
            $subcategory = ModsSubcategories::findOne(['name' => $subcategory, 'category_id' => $category->id]);
            $all_subcategories = ModsSubcategories::findAll(['category_id' => $category->id]);
            if(!$subcategory) return $this->redirect(['site/modifications']);
            return $this->render('mods_category', [
                'mods' => $mods,
                'category' => $category,
                'subcategory' => $subcategory,
                'all_subcategories' => $all_subcategories
            ]);
        }

        // displaying mod start page
        else{
            return $this->render('mods');
        }
    }
    
    public function actionMembers(){

        // edit member
        if(Yii::$app->request->get('action') == 'edit' && Yii::$app->request->get('id') && User::isAdmin()){
            $model = new MemberForm(Yii::$app->request->get('id'));
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->editMember(Yii::$app->request->get('id'))){
                    return $this->redirect(['site/members', 'id' => Yii::$app->request->get('id'), 'action' => 'edit']);
                }
            }
            return $this->render('edit_member', [
                'model' => $model
            ]);
        }

        // set all members month and other scores to '0'
        if(Yii::$app->request->get('action') == 'zero' && User::isAdmin()){
            VtcMembers::zeroScores();
            return $this->redirect(['site/members', 'action' => 'stats']);
        }

        // fire member
        if(Yii::$app->request->get('action') == 'fired' && Yii::$app->request->get('id') && User::isAdmin()){
            if(VtcMembers::fireMember(Yii::$app->request->get('id'))){
                return $this->redirect(['site/members']);
            }
        }

        // handling ajax
        if(Yii::$app->request->isAjax){
            if(Yii::$app->request->post('id') && Yii::$app->request->post('scores') && Yii::$app->request->post('target')){
                if($result = VtcMembers::addScores(Yii::$app->request->post('id'), Yii::$app->request->post('scores'), Yii::$app->request->post('target'))){
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return [
                        'status' => 'OK',
                        'scores' => $result
                    ];
                }
            }
        }

        // displaying stats
        VtcMembers::cleanVacations();
        $members = VtcMembers::getMembers(false);
        $all_members = VtcMembers::getAllMembers();
        if(Yii::$app->request->get('action') == 'stats'){

            // handling ajax
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                if(Yii::$app->request->post('method') == 'get_bans') {
                    return [
                        'bans' => VtcMembers::getBans(Yii::$app->request->post('steamid64')),
                        'status' => 'OK'
                    ];
                }
                return [
                    'status' => 'Error'
                ];
            }

            return $this->render('members-stat', [
                'all_members' => $members
            ]);
        }
        return $this->render('members', [
            'all_members' => $all_members
        ]);
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
            $model->visible_email = $user->visible_email == '1';
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
        return $this->render('profile', [
            'user' => $user,
            'member' => $member,
            'model' => $model,
            'edit' => $edit
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

    public function actionTrailers(){
        if(Yii::$app->request->get('action')){
            if(User::isAdmin()){
                switch(Yii::$app->request->get('action')){
                    case 'add': {
                        $model = new TrailersForm();
                        if($model->load(Yii::$app->request->post()) && $model->validate()){
                            if($model->addTrailer()){
                                return $this->redirect(['site/trailers']);
                            }
                        }else{
                            return $this->render('edit_trailer', ['model' => $model]);
                        }
                        break;
                    }
                    case 'edit': {
                        if(Yii::$app->request->get('action')){
                            $model = new TrailersForm(Yii::$app->request->get('id'));
                            if($model->load(Yii::$app->request->post()) && $model->validate()) {
                                if($model->editTrailer(Yii::$app->request->get('id'))) {
                                    return $this->redirect(['site/trailers']);
                                }
                            }else{
                                return $this->render('edit_trailer', ['model' => $model]);
                            }
                        }else{
                            return $this->redirect(['site/trailers']);
                        }
                        break;
                    }
                    case 'delete': {
                        if(Trailers::deleteTrailer(Yii::$app->request->get('id'))){
                            return $this->redirect(['site/trailers']);
                        }else{
                            return $this->redirect(Yii::$app->request->referrer);
                        }
                        break;
                    }
                    default: return $this->redirect(['site/trailers']);
                }
            }else{
                return $this->render('error');
            }
        }
        $query = Trailers::find();
        if(Yii::$app->request->get('q')){
            $q = Yii::$app->request->get('q');
            $query->where(['like', 'name', $q])
                ->orWhere(['like', 'description', $q]);
        }
        $total = $query->count();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $total
        ]);
        $trailers = $query->orderBy(['name' => SORT_ASC])->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('trailers',[
            'trailers' => $trailers,
            'currentPage' => Yii::$app->request->get('page', 1),
            'totalPages' => $pagination->getPageCount(),
            'pagination' => $pagination,
            'total' => $total
        ]);
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