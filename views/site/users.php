<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Зарегистрированые пользователи сайта - Volvo Trucks'; ?>

<div class="container">
    <div class="card-panel grey lighten-4 search">
        <form method="get">
            <div class="input-field">
                <button type="submit" class="prefix user-search waves-effect circle">
                    <i class="material-icons">search</i>
                </button>
                <input placeholder="Искать пользователя" type="text" name="q" <?php if(Yii::$app->request->get('q')): ?>value="<?= Yii::$app->request->get('q') ?>"<?php endif ?>>
                <?php if(Yii::$app->request->get('q')) : ?>
                    <a href="<?= Url::to(['site/users']) ?>" class="search-reset waves-effect circle">
                        <i class="material-icons">clear</i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <h5>Всего <?= $total ?></h5>
    <?php foreach($users as $user): ?>
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
    <?php endforeach; ?>
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'firstPageLabel' => 'Начало',
        'lastPageLabel' => 'Конец',
        'options' => [
            'class' => 'pagination center'
        ],
        'prevPageCssClass' => 'waves-effect',
        'pageCssClass' => 'waves-effect',
        'nextPageCssClass' => 'waves-effect',
        'activePageCssClass' => 'active waves-effect',
        'disabledPageCssClass' => 'disabled',
        'maxButtonCount' => 5
    ]) ?>
</div>
