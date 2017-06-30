<?php

use yii\helpers\Url;
use app\models\User;
use app\models\VtcMembers;

$this->title = 'Заявления Volvo Trucks';
$is_member = VtcMembers::find()->select(['id'])->where(['user_id' => Yii::$app->user->id])->one() ? true : false;
?>

<div class="container claims">
    <div class="card grey lighten-4">
        <div class="card-image no-img" style="background-image: url(assets/img/claims.jpg)">
            <span class="card-title">Заявления Volvo Trucks</span>
        </div>
        <div class="card-content row">

<!--        tabs-->
            <div class="col s12">
                <ul class="tabs grey lighten-4">
                    <li class="tab col s3"><a href="#recruit">На вступление</a></li>
                    <li class="tab col s3"><a href="#dismissal">На увольнение</a></li>
                    <li class="tab col s3"><a href="#nickname">На смену ника</a></li>
                    <li class="tab col s3"><a href="#vacation">На отпуск</a></li>
                </ul>
            </div>

<!--        tabs content-->
            <div id="recruit" class="col s12 card-content">
                <div class="valign-wrapper" style="justify-content: space-between">
                    <h5>Заявления на вступление</h5>
                    <?php if(Yii::$app->user->isGuest || !$is_member) : ?>
                        <a href="<?= Url::to(['site/recruit']) ?>" class="btn indigo waves-effect waves-light">
                            Вступить в ВТК<i class="material-icons right">add_circle</i>
                        </a>
                    <?php endif ?>
                </div>
                <ul class="collection collapsible">
                    <?php foreach ($recruits as $recruit): ?>
                        <?php switch ($recruit->status){
                            case '1': $badge_color = 'light-green lighten-4-5'; break;
                            case '2': $badge_color = 'red lighten-4-5'; break;
                            case '0':
                            default : $badge_color = ''; break;
                        } ?>
                        <li>
                            <div class="collapsible-header collection-item avatar <?= $badge_color ?>">
                                <div class="collapsible-top valign-wrapper flex">
                                    <?php $user = User::find()->select(['picture', 'first_name', 'last_name', 'last_active'])->where(['id' => $recruit->user_id])->one() ?>
                                    <a href="<?=Url::to(['site/profile', 'id' => $recruit->user_id])?>" class="circle z-depth-3 claim-img <?php if(User::isOnline($user)) : ?>online<?php endif ?>" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?= $user->picture ?>)">
                                    </a>
                                    <span class="center-align title"><?= $user->first_name ?> <?= $user->last_name ?></span>
                                    <span class="center-align title"><?= \app\controllers\SiteController::getRuDate($recruit->date) ?></span>
                                    <span class="center-align title badge-block">
                                        <span><b><?= \app\models\ClaimsRecruit::getStatusTitle($recruit->status) ?></b><br><?= $recruit->reason ?></span>
                                    </span>

                                    <?php if($recruit->viewed):
                                        $by = User::find()->where(['id' => $recruit->viewed])->one() ?>
                                        <span class="center-align title">
                                            Рассмотрел:<br><?= $by->first_name ?> <?= $by->last_name ?>
                                        </span>
                                    <?php endif ?>
                                </div>
                                <div class="collapsible-bottom center">
                                    <?php if(User::isAdmin() && $recruit->status == 0) : ?>
                                        <a onclick='return confirm("Одобрить заявку?")' href="<?= Url::to(['site/claims',
                                            'claim' => 'recruit',
                                            'id' => $recruit->id,
                                            'action' => 'apply'])
                                        ?>" class="btn indigo darken-3">
                                            <i class="material-icons left">done</i>Одобрить
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!Yii::$app->user->isGuest && (Yii::$app->user->id == $recruit->user_id ||
                                            Yii::$app->user->identity->admin == 1) && $recruit->status == 0) : ?>
                                        <a href="<?= Url::to(['site/claims',
                                            'claim' => 'recruit',
                                            'id' => $recruit->id,
                                            'action' => 'edit'])
                                        ?>" class="btn indigo darken">
                                            <i class="material-icons left">edit</i>Редактировать
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
                                        <a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/claims',
                                            'claim' => 'recruit',
                                            'id' => $recruit->id,
                                            'action' => 'delete'])
                                        ?>" class="btn indigo darken">
                                            <i class="material-icons left">delete</i>Удалить
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="collapsible-body">
                                <div class="flex" style="justify-content: space-between;">
                                    <div class="hear-from">
                                        <b>Откуда узнали?</b>
                                        <span><?php if($recruit->hear_from){ echo htmlentities($recruit->hear_from); }else{ echo '&mdash;'; } ?></span>
                                    </div>
                                    <div class="invited">
                                        <b>Кто пригласил?</b>
                                        <span><?php if($recruit->invited_by){ echo htmlentities($recruit->invited_by); }else{ echo '&mdash;'; } ?></span>
                                    </div>
                                    <div class="comment">
                                        <b>Комментарий:</b>
                                        <span><?php if($recruit->comment){ echo htmlentities($recruit->comment); }else{ echo '&mdash;'; } ?></span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div id="dismissal" class="col s12 card-content">
                <div class="valign-wrapper" style="justify-content: space-between">
                    <h5>Заявления на увольнение</h5>
                    <?php if(!Yii::$app->user->isGuest && $is_member) : ?>
                        <a href="<?= Url::to(['site/claims', 'claim' => 'dismissal', 'action' => 'add']) ?>" class="btn indigo waves-effect waves-light">
                            Подать заявление на увольнение<i class="material-icons right">add_circle</i>
                        </a>
                    <?php endif ?>
                </div>
                <ul class="collection collapsible">
                    <?php if($fired) {
                        foreach ($fired as $claim): ?>
                            <?php switch ($claim->status) {
                            case '1':
                                $badge_color = 'light-green lighten-4-5';
                                break;
                            case '2':
                                $badge_color = 'red lighten-4-5';
                                break;
                            case '0':
                            default :
                                $badge_color = '';
                                break;
                        } ?>
                            <li>
                                <div class="collapsible-header collection-item avatar <?= $badge_color ?>">
                                    <div class="collapsible-top valign-wrapper flex">
                                        <?php $user = User::find()->select(['picture', 'nickname', 'id', 'last_active'])->where(['id' => $claim->user_id])->one(); ?>
                                        <a href="<?= Url::to(['site/profile', 'id' => $claim->user_id]) ?>" class="circle z-depth-3 claim-img <?php if(User::isOnline($user)) : ?>online<?php endif ?>" style="background-image: url(<?= Yii::$app->request->baseUrl ?>/images/users/<?= $user->picture ?>)"></a>
                                        <span class="center-align title"><?= htmlentities($user->nickname) ?></span>
                                        <span class="center-align title"><?= \app\controllers\SiteController::getRuDate($claim->date) ?></span>
                                        <span class="center-align title badge-block">
                                            <span><b><?= \app\models\ClaimsRecruit::getStatusTitle($claim->status) ?></b></span>
                                        </span>
                                        <?php if($claim->viewed):
                                            $by = User::find()->where(['id' => $claim->viewed])->one() ?>
                                            <span class="center-align title">
                                            Рассмотрел:<br><?= $by->first_name ?> <?= $by->last_name ?>
                                        </span>
                                        <?php endif ?>
                                    </div>
                                    <div class="collapsible-bottom center">
                                        <?php if(User::isAdmin() && $claim->status == 0) : ?>
                                            <a onclick='return confirm("Одобрить заявку?")'
                                               href="<?= Url::to(['site/claims',
                                                   'claim' => 'dismissal',
                                                   'id' => $claim->id,
                                                   'action' => 'apply'])
                                               ?>" class="btn indigo darken-3">
                                                <i class="material-icons left">done</i>Одобрить
                                            </a>
                                        <?php endif; ?>
                                        <?php if(!Yii::$app->user->isGuest && (Yii::$app->user->id == $claim->user_id ||
                                                Yii::$app->user->identity->admin == 1) && $claim->status == 0
                                        ) : ?>
                                            <a href="<?= Url::to(['site/claims',
                                                'claim' => 'dismissal',
                                                'id' => $claim->id,
                                                'action' => 'edit'])
                                            ?>" class="btn indigo darken">
                                                <i class="material-icons left">edit</i>Редактировать
                                            </a>
                                        <?php endif; ?>
                                        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
                                            <a onclick='return confirm("Удалить?")' href="<?= Url::to(['site/claims',
                                                'claim' => 'dismissal',
                                                'id' => $claim->id,
                                                'action' => 'delete'])
                                            ?>" class="btn indigo darken">
                                                <i class="material-icons left">delete</i>Удалить
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="collapsible-body">
                                    <div class="flex" style="justify-content: space-between;">
                                        <div class="hear-from">
                                            <b>Причина увольнения:</b>
                                            <span><?= htmlentities($claim->reason) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach;
                    }?>
                </ul>
            </div>

            <div id="nickname" class="col s12 card-content">
                <div class="valign-wrapper" style="justify-content: space-between">
                    <h5>Заявления на смену ника</h5>
                    <?php if(!Yii::$app->user->isGuest && $is_member) : ?>
                        <a href="<?= Url::to(['site/claims', 'claim' => 'nickname', 'action' => 'add']) ?>" class="btn indigo waves-effect waves-light">
                            Подать заявление на смену ника<i class="material-icons right">add_circle</i>
                        </a>
                    <?php endif ?>
                </div>
                <ul class="collection">
                    <?php foreach ($nickname as $member): ?>
                        <?php switch ($member->status) {
                            case '1':
                                $badge_color = 'light-green lighten-4-5';
                                break;
                            case '2':
                                $badge_color = 'red lighten-4-5';
                                break;
                            case '0':
                            default :
                                $badge_color = '';
                                break;
                        } ?>
                        <li>
                            <div class="collection-item avatar <?= $badge_color ?>">
                                <div class="collapsible-top valign-wrapper flex">
                                    <?php $user = User::find()->select(['id', 'picture', 'nickname', 'last_active'])->where(['id' => $member->user_id])->one();?>
                                    <a href="<?= Url::to(['site/profile', 'id' => $member->user_id]) ?>" class="circle z-depth-3 claim-img <?php if(User::isOnline($user)) : ?>online<?php endif ?>" style="background-image: url(<?= Yii::$app->request->baseUrl ?>/images/users/<?= $user->picture ?>)">
                                    </a>
                                    <span class="center-align title"><b><?= htmlentities($member->old_nickname) ?></b> &rArr; <b><?= htmlentities($member->new_nickname) ?></b></span>
                                    <span class="center-align title"><?= \app\controllers\SiteController::getRuDate($member->date) ?></span>
                                    <span class="center-align title badge-block">
                                        <?php switch ($member->status){
                                            case '1': $badge_color = 'green'; break;
                                            case '2': $badge_color = 'red'; break;
                                            case '0':
                                            default : $badge_color = 'yellow'; break;
                                        } ?>
                                        <span class="center-align title badge-block">
                                            <span><b><?= \app\models\ClaimsRecruit::getStatusTitle($member->status) ?></b><br><?= $member->reason ?></span>
                                        </span>
                                    </span>
                                    <?php if($member->viewed):
                                        $by = User::find()->where(['id' => $member->viewed])->one() ?>
                                        <span class="center-align title">
                                            Рассмотрел:<br><?= $by->first_name ?> <?= $by->last_name ?>
                                        </span>
                                    <?php endif ?>
                                </div>
                                <div class="collapsible-bottom center">
                                    <?php if(User::isAdmin() && $member->status == 0) : ?>
                                        <a onclick='return confirm("Одобрить заявку?")' href="<?= Url::to(['site/claims',
                                            'claim' => 'nickname',
                                            'id' => $member->id,
                                            'action' => 'apply'])
                                        ?>" class="btn indigo darken-3 waves-effect waves-light">
                                            <i class="material-icons left">done</i>Одобрить
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!Yii::$app->user->isGuest && (Yii::$app->user->id == $member->user_id ||
                                            Yii::$app->user->identity->admin == 1) && $member->status == 0) : ?>
                                        <a href="<?= Url::to(['site/claims',
                                            'claim' => 'nickname',
                                            'id' => $member->id,
                                            'action' => 'edit'])
                                        ?>" class="btn indigo darken waves-effect waves-light">
                                            <i class="material-icons left">edit</i>Редактировать
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
                                        <a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/claims',
                                            'claim' => 'nickname',
                                            'id' => $member->id,
                                            'action' => 'delete'])
                                        ?>" class="btn indigo darken waves-effect waves-light">
                                            <i class="material-icons left">delete</i>Удалить
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div id="vacation" class="col s12 card-content">
                <div class="valign-wrapper" style="justify-content: space-between">
                    <h5>Заявления на отпуск</h5>
                    <?php if(!Yii::$app->user->isGuest && $is_member) : ?>
                        <a href="<?= Url::to(['site/claims', 'claim' => 'vacation', 'action' => 'add']) ?>" class="btn indigo waves-effect waves-light">
                            Подать заявление на отпуск<i class="material-icons right">add_circle</i>
                        </a>
                    <?php endif ?>
                </div>
                <ul class="collection collapsible">
                    <?php foreach ($vacation as $claim): ?>
                        <?php switch ($claim->status) {
                            case '1':
                                $badge_color = 'light-green lighten-4-5';
                                break;
                            case '2':
                                $badge_color = 'red lighten-4-5';
                                break;
                            case '0':
                            default :
                                $badge_color = '';
                                break;
                        } ?>
                        <li>
                            <div class="collapsible-header collection-item avatar <?= $badge_color ?>">
                                <div class="collapsible-top valign-wrapper flex">
                                    <?php $user = User::find()->select(['picture', 'nickname', 'id', 'last_active'])->where(['id' => $claim->user_id])->one() ?>
                                    <a href="<?= Url::to(['site/profile', 'id' => $claim->user_id]) ?>" class="circle z-depth-3 claim-img <?php if(User::isOnline($user)) : ?>online<?php endif ?>" style="background-image: url(<?= Yii::$app->request->baseUrl ?>/images/users/<?= $user->picture ?>)">
                                    </a>
                                    <span class="center-align title"><b><?= htmlentities($user->nickname) ?></b></span>
                                    <span class="center-align title">С <?= \app\controllers\SiteController::getRuDate($claim->date) ?><br>
									<b><?= $claim->vacation_undefined == '1' ? 'На Н. срок' : 'По ' . \app\controllers\SiteController::getRuDate($claim->to_date) ?></b></span>
                                    <span class="center-align title badge-block">
                                        <span><b><?= \app\models\ClaimsRecruit::getStatusTitle($claim->status) ?></b></span>
                                    </span>
                                    <?php if($claim->viewed):
                                        $by = User::find()->where(['id' => $claim->viewed])->one() ?>
                                        <span class="center-align title">
                                            Рассмотрел:<br><?= $by->first_name ?> <?= $by->last_name ?>
                                        </span>
                                    <?php endif ?>
                                </div>
                                <div class="collapsible-bottom center">
                                    <?php if(User::isAdmin() && $claim->status == 0) : ?>
                                        <a onclick='return confirm("Одобрить заявку?")'
                                           href="<?= Url::to(['site/claims',
                                               'claim' => 'vacation',
                                               'id' => $claim->id,
                                               'action' => 'apply'])
                                           ?>" class="btn indigo darken-3">
                                            <i class="material-icons left">done</i>Одобрить
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!Yii::$app->user->isGuest && (Yii::$app->user->id == $claim->user_id ||
                                            Yii::$app->user->identity->admin == 1) && $claim->status == 0
                                    ) : ?>
                                        <a href="<?= Url::to(['site/claims',
                                            'claim' => 'vacation',
                                            'id' => $claim->id,
                                            'action' => 'edit'])
                                        ?>" class="btn indigo darken">
                                            <i class="material-icons left">edit</i>Редактировать
                                        </a>
                                    <?php endif; ?>
                                    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
                                        <a onclick='return confirm("Удалить?")' href="<?= Url::to(['site/claims',
                                            'claim' => 'vacation',
                                            'id' => $claim->id,
                                            'action' => 'delete'])
                                        ?>" class="btn indigo darken">
                                            <i class="material-icons left">delete</i>Удалить
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="collapsible-body">
                                <div class="flex" style="justify-content: space-between;">
                                    <div class="hear-from">
                                        <b>Причина:</b>
                                        <span>
                                            <?php if($claim->reason){ echo htmlentities($claim->reason); }else{ echo '&mdash;'; } ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>