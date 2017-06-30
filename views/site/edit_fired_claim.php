<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать заявление на увольнение - Volvo Trucks';
?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4 user">
                <div class="link-image">
                    <a href="<?= Url::to(['site/profile', 'id' => $user->id]) ?>" class=" circle z-depth-3 waves-effect waves-light <?php if(\app\models\User::isOnline($user)) : ?>online<?php endif ?>" style="background-image: url(<?= Yii::$app->request->baseUrl ?>/web/images/users/<?= $user->picture ?>)">
                    </a>
                </div>
                <div class="user-info row">
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><span><b><?= $user->company != '' ? '['.$user->company.']' : '' ?></b></span></div>
                        <div class="col l7 s7 profile-info"><span><b><?=$user->nickname?></b></span></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><span>Имя:</span></div>
                        <div class="col l7 s7 profile-info"><span><b><?=$user->first_name?></b></span></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><span>Фамилия:</span></div>
                        <div class="col l7 s7 profile-info"><span><b><?=$user->last_name?></b></span></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align truncate"><span>Дата рождения:</span></div>
                        <div class="col l7 s7 profile-info truncate"><span><b><?= \app\controllers\SiteController::getRuDate($user->birth_date) ?></b></span></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><span>Страна:</span></div>
                        <div class="col l7 s7 profile-info"><span><b><?=$user->country?></b></span></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><span>Город:</span></div>
                        <div class="col l7 s7 profile-info"><span><b><?=$user->city?></b></span></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><span>Зарегестрирован:</span></div>
                        <div class="col l7 s7 profile-info"><span><b><?= \app\controllers\SiteController::getRuDate($user->registered) ?></b></span></div>
                    </div>
                </div>
                <div class="user-links">
                    <ul class="socials links">
                        <?php if($user->vk){ ?>
                            <li class="vk z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?=$user->vk?>"></a></li>
                        <?php }
                        if($user->steam){ ?>
                            <li class="steam z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?=$user->steam?>"></a></li>
                        <?php }
                        if($user->truckersmp){ ?>
                            <li class="truckers-mp z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?=$user->truckersmp?>"></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <?php if($model->status == '1') : ?>
                    <div class="card-panel yellow lighten-2">
                        <i class="left material-icons">report_problem</i>Одобреные заявки на увольнение, редактированию не подлежат!
                    </div>
                <?php endif ?>
                <div class="input-field">
                    <?php if(Yii::$app->user->id == $model->user_id && $model->status == 0){ ?>
                        <?= $form->field($model, 'reason')->textarea(['class' => 'materialize-textarea']) ?>
                    <?php }else{ ?>
                        <?= $form->field($model, 'reason')->textarea(['readonly' => true, 'class' => 'materialize-textarea']) ?>
                    <?php } ?>
                </div>
                <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == '1') : ?>
                    <div class="row">
                        <div class="input-field col l5 s12">
                            <?= $form->field($model, 'status')->dropdownList([
                                '0' => 'Рассматривается',
                                '1' => 'Одобрено',
                                '2' => 'Отказ'
                            ])->label(false)->error(false) ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <?php if(\app\models\User::isAdmin()) : ?>
            <?= $form->field($model, 'viewed')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
        <?php endif ?>
        <div class="fixed-action-btn">
            <?=Html::submitButton(Html::tag('i', 'save', [
                    'class' => 'large material-icons'
            ]), ['class' => 'btn-floating btn-large red']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>