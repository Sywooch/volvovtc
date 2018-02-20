<?php

namespace app\controllers;

use app\models\Trailers;
use app\models\TrailersCategories;
use app\models\TrailersForm;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\Notifications;
use app\models\User;
use Yii;
use yii\web\Response;

class TrailersController extends Controller{

    public function actions(){
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }

    public function beforeAction($action){
		if(Yii::$app->user->isGuest){
			Url::remember();
			return $this->redirect(['site/login']);
		}else{
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
			if(!User::canCreateConvoy()){
				return $this->redirect(['//site/error']);
			}
        }
        return parent::beforeAction($action);
    }

    public function actionIndex(){
		$query = Trailers::find();
		if(Yii::$app->request->get('q')){
			$q = Yii::$app->request->get('q');
			$query->where(['like', 'name', $q])
				->orWhere(['like', 'description', $q]);
		}
		if(Yii::$app->request->get('game')){
			$game = Yii::$app->request->get('game');
			$query->andWhere(['game' => $game]);
		}
		if(Yii::$app->request->get('category')){
			$category = Yii::$app->request->get('category');
			$query->andWhere(['category' => $category]);
		}
		$total = $query->count();
		$pagination = new Pagination([
			'defaultPageSize' => 8,
			'totalCount' => $total
		]);
		$trailers = $query->orderBy(['name' => SORT_ASC])->offset($pagination->offset)->limit($pagination->limit)->all();
		$categories = TrailersCategories::find()->select(['name', 'title'])->orderBy(['title' => SORT_ASC])->indexBy('name')->asArray()->all();
		return $this->render('index',[
			'trailers' => $trailers,
			'currentPage' => Yii::$app->request->get('page', 1),
			'totalPages' => $pagination->getPageCount(),
			'pagination' => $pagination,
			'total' => $total,
			'categories' => $categories
		]);
    }

    public function actionAdd() {
		$model = new TrailersForm();
		$categories = TrailersCategories::find()->select(['name', 'title'])->indexBy('name')->asArray()->all();
		$new_cats[0] = 'Без категории';
		foreach ($categories as $category){
			$new_cats[$category['name']] = $category['title'];
		}
		if($model->load(Yii::$app->request->post()) && $model->validate()){
			if($model->addTrailer()){
				return $this->redirect(['trailers/index']);
			}
		}
		return $this->render('edit_trailer', [
			'model' => $model,
			'categories' => $new_cats
		]);
    }

    public function actionEdit(){
		$model = new TrailersForm(Yii::$app->request->get('id'));
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			if($model->editTrailer(Yii::$app->request->get('id'))) {
				return $this->goBack();
			}
		}
		$categories = TrailersCategories::find()->select(['name', 'title'])->orderBy(['title' => SORT_ASC])->asArray()->all();
		$new_cats[0] = 'Без категории';
		foreach ($categories as $category){
			$new_cats[$category['name']] = $category['title'];
		}
		return $this->render('edit_trailer', [
			'model' => $model,
			'categories' => $new_cats
		]);
    }

    public function actionRemove(){
		if(Trailers::deleteTrailer(Yii::$app->request->get('id'))){
			return $this->redirect(['trailers/index']);
		}else{
			return $this->goBack();
		}
    }

    public function actionGetinfo(){
        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if(Yii::$app->request->post('trailers')) {
                $trailers = Trailers::getTrailersInfo(Yii::$app->request->post('trailers'));
                return [
                    'status' => 'OK',
                    'trailers' => $trailers
                ];
            }
            return [
                'status' => 'Error'
            ];
        }else{
            return $this->render('//site/error');
        }
    }

}