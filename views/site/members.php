<?php

use yii\helpers\Url;

$this->title = 'Сотрудники Volvo Trucks'; ?>

<div class="container">
    <div class="card grey lighten-4">
        <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/assets/img/members.jpg)">
            <span class="card-title text-shadow">Сотрудники Volvo Trucks</span>
        </div>
        <div class="card-content">
            <div class="row center">
                <a href="<?= Url::to(['site/members', 'action' => 'stats']) ?>" class="btn btn-large indigo darken-3 waves-effect waves-light">
                    <i class="material-icons notranslate left">grid_on</i>Смотреть таблицу статистики</a>
            </div>
            <div class="row">
                <ul class="collection">
                    <?php foreach($all_members as $member): ?>
                        <li class="collection-item avatar">
                            <a class="member-img circle z-depth-3 waves-effect waves-light <?php if(\app\models\User::isOnline($member->user_id)) : ?>online<?php endif ?>" href="<?= Url::to(['site/profile', 'id' => $member->user_id->id]) ?>" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?= $member->user_id->picture ?>)"></a>
                            <a href="<?= Url::to(['site/profile', 'id' => $member->user_id->id]) ?>" class="black-text title"><?= $member->user_id->first_name . ' ' . $member->user_id->last_name ?></a>
                            <p>Дата рождения:
                                <span class="nowrap"><b><?= \app\controllers\SiteController::getRuDate($member->user_id->birth_date) ?></b></span>
                                <span class="nowrap">(<?= \app\models\User::getUserAge($member->user_id->birth_date) ?>)</span>
                            </p>
                            <?php $datetime1 = new DateTime($member->start_date);
                            $datetime2 = new DateTime(); ?>
                            <p>В компании с
                                <span class="nowrap"><b><?= \app\controllers\SiteController::getRuDate($member->start_date) ?></b></span>
                                <span class="nowrap">(<?= $datetime1->diff($datetime2)->format('%a дней') ?>)</span>
                            </p>
                            <div class="secondary-content">
                                <ul class="user-links right" style="width: 84px;">
                                    <?php if($member->user_id->vk) : ?>
                                        <li class="vk z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?= $member->user_id->vk ?>"></a></li>
                                    <?php endif; ?>
                                    <?php if($member->user_id->steam) : ?>
                                        <li class="steam z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?= $member->user_id->steam ?>"></a></li>
                                    <?php endif; ?>
                                    <?php if($member->user_id->truckersmp) : ?>
                                        <li class="truckers-mp z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?= $member->user_id->truckersmp ?>"></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>