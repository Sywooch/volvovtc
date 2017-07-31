<?php

use yii\helpers\Url;
use app\models\User; ?>

<!-- recruit tab -->
<div id="recruit">

    <div class="valign-wrapper" style="justify-content: space-between">
        <h5>Заявления на вступление</h5>
        <?php if(!User::isVtcMember()) : ?>
            <a href="<?= Url::to(['site/recruit']) ?>" class="btn indigo waves-effect waves-light">
                Вступить в ВТК<i class="material-icons right">add_circle</i>
            </a>
        <?php endif ?>
    </div>

    <?php foreach($recruits as $recruit) :
        switch ($recruit->status){
            case '1': $color_class = 'light-green lighten-4-5'; break;
            case '2': $color_class = 'red lighten-4-5'; break;
            case '0':
            default : $color_class = 'grey lighten-4'; break;
        }
        $user = User::find()->select(['picture', 'first_name', 'last_name'])->where(['id' => $recruit->user_id])->one(); ?>
        <div class="card horizontal hoverable <?= $color_class ?>">
            <div class="card-image grey lighten-4 claim-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?= $user->picture ?>)">
                <a href="<?= Url::to(['site/profile', 'id' => $recruit->user_id]) ?>" class="waves-effect waves-light"></a>
            </div>
            <div class="card-stacked">
                <div class="card-content">
                    <a class="card-title black-text" href="<?= Url::to(['site/profile', 'id' => $recruit->user_id]) ?>"><?= $user->first_name ?> <?= $user->last_name ?></a>
                    <div class="flex claim-info">
                        <div style="max-width: 70%">
                            <p class="nowrap"><?= \app\controllers\SiteController::getRuDate($recruit->date) ?></p>
                            <?php if($recruit->hear_from) : ?>
                                <p><b>Откуда узнали?</b> <?= strip_tags($recruit->hear_from) ?></p>
                            <?php endif ?>
                            <?php if($recruit->invited_by) : ?>
                                <p><b>Кто пригласил?</b> <?= strip_tags($recruit->invited_by) ?></p>
                            <?php endif ?>
                            <?php if($recruit->comment) : ?>
                                <p><b>Комментарий:</b> <?= strip_tags($recruit->comment, '<br>'); ?></p>
                            <?php endif ?>
                        </div>
                        <div class="claim-status" style="flex: 1;">
                            <p><b class="fs17"><?= \app\models\ClaimsRecruit::getStatusTitle($recruit->status) ?></b><br><?= strip_tags($recruit->reason) ?></p>
                            <?php if($recruit->viewed):
                                $by = User::find()->where(['id' => $recruit->viewed])->one() ?>
                                <p class="grey-text">Рассмотрел: <?= $by->first_name ?> <?= $by->last_name ?></p>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <?php if(!Yii::$app->user->isGuest && (Yii::$app->user->id == $recruit->user_id ||
                        Yii::$app->user->identity->admin == 1) && $recruit->status == 0 || User::isAdmin()) : ?>
                    <div class="card-action">
                        <?php if(User::isAdmin() && $recruit->status == 0) : ?>
                            <a onclick='return confirm("Одобрить заявку?")' href="<?= Url::to(['site/claims',
                                'claim' => 'recruit',
                                'id' => $recruit->id,
                                'action' => 'apply'])
                            ?>"><i class="material-icons to-text">done</i>Одобрить
                            </a>
                        <?php endif; ?>
                        <?php if(!Yii::$app->user->isGuest && (Yii::$app->user->id == $recruit->user_id ||
                                Yii::$app->user->identity->admin == 1) && $recruit->status == 0) : ?>
                            <a href="<?= Url::to(['site/claims',
                                'claim' => 'recruit',
                                'id' => $recruit->id,
                                'action' => 'edit'])
                            ?>"><i class="material-icons to-text">edit</i>Редактировать
                            </a>
                        <?php endif; ?>
                        <?php if(User::isAdmin()) : ?>
                            <a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/claims',
                                'claim' => 'recruit',
                                'id' => $recruit->id,
                                'action' => 'delete'])
                            ?>"><i class="material-icons to-text">delete</i>Удалить
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach ?>

</div>