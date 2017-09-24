<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Жалобы на сотрудников - Volvo Trucks';

?>

<div class="container">
    <?php if(count($appeals) > 0) : ?>
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'firstPageLabel' => 'Начало',
            'lastPageLabel' => 'Конец',
            'options' => [
                'class' => 'pagination center col m6 s12'
            ],
            'prevPageCssClass' => 'waves-effect',
            'pageCssClass' => 'waves-effect',
            'nextPageCssClass' => 'waves-effect',
            'activePageCssClass' => 'active waves-effect',
            'disabledPageCssClass' => 'disabled',
            'maxButtonCount' => 5
        ]) ?>
        <?php foreach($appeals as $appeal): ?>
            <div class="card horizontal hoverable yellow lighten-4<?php if($appeal->viewed == '0'): ?> grey<?php endif ?>">
                <div class="card-image no-img_horizontal" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?= $appeal->appealed_user->picture ?>)"></div>
                <div class="card-stacked">
                    <div class="card-content">
                        <h5 class="light">Жалоба на
                            <?php if(\app\models\User::isVtcMember($appeal->appealed_user->id)) : ?>
                                <a href="<?= Url::to(['members/edit', 'id' => $appeal->appealed_member->id]) ?>" class="black-text">
                                    <?= '[Volvo Trucks] ' ?><?= $appeal->appealed_user->nickname ?>
                                </a>
                            <?php else: ?>
                                <a href="<?= Url::to(['site/profile', 'id' => $appeal->appealed_user->id]) ?>" class="black-text">
                                    <?php if($appeal->appealed_user->company) : ?>
                                        <?= '['.$appeal->appealed_user->company.'] ' ?>
                                    <?php endif ?>
                                    <?= $appeal->appealed_user->nickname ?>
                                </a>
                            <?php endif ?>
                        </h5>
                        <p class="grey-text">
                            <?php if($appeal->is_anonymous == '0') : ?>
                                От <?= '['.$appeal->from_user->company.'] ' ?><?= $appeal->from_user->nickname ?>
                            <?php else: ?>
                                Анонимная жалоба
                            <?php endif ?>
                        </p>
                        <p><b>Описание:</b> <?= $appeal->description ?></p>
                        <p><b>Доказательства:</b> <?= $appeal->proof ?></p>
                    </div>
                    <div class="card-action">
                        <?php if($appeal->viewed == '0'): ?>
                            <a href="<?= Url::to(['appeals/viewed', 'id' => $appeal->id]) ?>">Просмотрено</a>
                        <?php endif ?>
                        <a href="<?= Url::to(['appeals/remove', 'id' => $appeal->id]) ?>">Удалить</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'firstPageLabel' => 'Начало',
            'lastPageLabel' => 'Конец',
            'options' => [
                'class' => 'pagination center col m6 s12'
            ],
            'prevPageCssClass' => 'waves-effect',
            'pageCssClass' => 'waves-effect',
            'nextPageCssClass' => 'waves-effect',
            'activePageCssClass' => 'active waves-effect',
            'disabledPageCssClass' => 'disabled',
            'maxButtonCount' => 5
        ]) ?>
    <?php else: ?>
        <h5 class="light">Нет жалоб</h5>
    <?php endif ?>
</div>