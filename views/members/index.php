<?php

use yii\helpers\Url;

$this->title = 'Сотрудники Volvo Trucks'; ?>

<div class="parallax-container parallax-shadow" style="height: 400px;">
    <div class="container">
        <h4 class="parallax-title light white-text text-shadow">Сотрудники Volvo Trucks</h4>
    </div>
    <div class="parallax"><img src="<?=Yii::$app->request->baseUrl?>/assets/img/members.jpg"></div>
</div>
<div class="container">
    <div class="row center">
        <a href="<?= Url::to(['members/stats']) ?>" class="btn btn-large indigo darken-3 waves-effect waves-light z-depth-3 light">
            <i class="material-icons notranslate left">grid_on</i>Смотреть таблицу статистики</a>
    </div>
    <?php foreach($all_members as $key => $member): ?>
        <div class="card horizontal grey lighten-4 hoverable">
            <div class="card-image no-img_horizontal" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?= $member->user_id->picture ?>)"></div>
            <div class="card-stacked">
                <div class="card-content">
                    <div class="card-title">
                        <?= $member->user_id->first_name . ' ' . $member->user_id->last_name ?>
                    </div>
                    <p class="grey-text">[Volvo Trucks] <?= $member->user_id->nickname ?></p>
                    <p>Дата рождения:
                        <span class="nowrap"><b><?= \app\controllers\SiteController::getRuDate($member->user_id->birth_date) ?></b></span>
                        <span class="nowrap">(<?= \app\models\User::getUserAge($member->user_id->birth_date) ?>)</span>
                    </p>
                    <p>В компании с
                        <span class="nowrap"><b><?= \app\controllers\SiteController::getRuDate($member->start_date) ?></b></span>
                        <span class="nowrap">(<?= \app\models\VtcMembers::getMemberDays($member->start_date); ?>)</span>
                    </p>
                </div>
                <div class="card-action">
                    <a href="<?= Url::to(['site/profile', 'id' => $member->user_id->id]) ?>" class="fs17">Профиль</a>
                    <?php if(\app\models\User::isAdmin()) : ?>
                        <a href="<?= Url::to(['members/edit', 'id' => $member->id]) ?>" class="fs17">Редактировать</a>
                    <?php endif ?>
                    <ul class="user-links right" style="width: 84px;">
                        <?php if($member->user_id->vk) : ?>
                            <li class="vk"><a class="waves-effect" target="_blank" href="<?= $member->user_id->vk ?>"></a></li>
                        <?php endif; ?>
                        <?php if($member->user_id->steam) : ?>
                            <li class="steam"><a class="waves-effect" target="_blank" href="<?= $member->user_id->steam ?>"></a></li>
                        <?php endif; ?>
                        <?php if($member->user_id->truckersmp) : ?>
                            <li class="truckers-mp<?php if(!\app\models\User::isAdmin() && $member->user_id->visible_truckersmp != 1):?> link-disabled<?php endif ?>">
                                <a class="waves-effect"<?php if(\app\models\User::isAdmin() || $member->user_id->visible_truckersmp == 1):?> href="<?= $member->user_id->truckersmp ?>"<?php endif ?> target="_blank"></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>