<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Профиль - Volvo Trucks';
?>

<div class="container">
    <div class="card grey lighten-4">
        <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/bg/<?=$user->bg_image?>)">
            <div class="profile-img z-depth-3 <?php if(\app\models\User::isOnline($user)) : ?>online<?php endif ?>" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?=$user->picture?>)"></div>
            <?php if($user->nickname) : ?>
                <span class="card-title text-shadow">
                    <?php if($user->company): ?>
                        [<?=$user->company ?>]
                    <?php endif ?>
                    <?=htmlentities($user->nickname) ?>
                </span>
            <?php else: ?>
                <span class="card-title text-shadow"><?= $user->username ?></span>
            <?php endif; ?>
        </div>
        <div class="card-content row profile-content">
            <div class="col l6 s12">
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>Имя:</p></div>
                    <div class="col l7 s7 profile-info"><p><?=$user->first_name?></p></div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>Фамилия:</p></div>
                    <div class="col l7 s7 profile-info"><p><?=$user->last_name?></p></div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>Возраст:</p></div>
                    <div class="col l7 s7 profile-info"><p><?= $user->age ?></p></div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align truncate"><p>Дата рождения:</p></div>
                    <div class="col l7 s7 profile-info truncate"><p><?= \app\controllers\SiteController::getRuDate($user->birth_date) ?></p></div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>Страна:</p></div>
                    <div class="col l7 s7 profile-info"><p><?=$user->country?></p></div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>Город:</p></div>
                    <div class="col l7 s7 profile-info"><p><?=$user->city?></p></div>
                </div>
            </div>
            <div class="col l6 s12">
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>E-Mail:</p></div>
                    <div class="col l7 s7 profile-info">
                        <p><?=$user->visible_email == '1' ? '<a href="mailto:'.$user->email.'">'.$user->email.'</a>' : '<i>E-Mail скрыт</i>' ?></p>
                    </div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align truncate"><p>Состоит в компании:</p></div>
                    <div class="col l7 s7 profile-info truncate"><p><?=$user->company?></p></div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>Наличие игр:</p></div>
                    <div class="col l7 s7 profile-info">
                        <p><?php
                            if($user->has_ets == '0' && $user->has_ats == '0') echo 'Нет игр';
                            else if($user->has_ets == '0' && $user->has_ats == '1') echo 'ATS';
                            else if($user->has_ets == '1' && $user->has_ats == '0') echo 'ETS2';
                            else if($user->has_ets == '1' && $user->has_ats == '1') echo 'ETS2 и ATS';
                            ?></p>
                    </div>
                </div>
                <div class="col l12 s12">
                    <div class="col l5 s5 right-align"><p>Профили:</p></div>
                    <div class="col l7 s7 profile-info">
                        <div class="profile-links">
                            <ul class="socials links" style="margin: 0;">
                                <?php if($user->vk){ ?>
                                    <li class="vk"><a class="waves-effect circle" target="_blank" href="<?=$user->vk?>"></a></li>
                                <?php }
                                if($user->steam){ ?>
                                    <li class="steam"><a class="waves-effect circle" target="_blank" href="<?=$user->steam?>"></a></li>
                                <?php }
                                if($user->truckersmp && ($user->visible_truckersmp == '1' || \app\models\User::isAdmin())){ ?>
                                    <li class="truckers-mp"><a class="waves-effect circle" target="_blank" href="<?=$user->truckersmp?>"></a></li>
                                <?php }
                                if(!$user->truckersmp && !$user->steam && !$user->vk){?>
                                    <li class="no-bg"><p>Нет указаных профилей</p></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(!Yii::$app->user->isGuest && $user->id === Yii::$app->user->identity->id){?>
            <div class="card-action">
                <a href="<?=Url::to(['site/profile', 'action' => 'edit'])?>" class="indigo-text text-darken-3">Редактировать профиль</a>
                <a href="<?=Url::to(['site/logout'])?>" class="indigo-text text-darken-3">Выйти</a>
            </div>
        <?php } ?>
    </div>
</div>