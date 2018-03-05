<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Модерация достижений - Volvo Trucks'; ?>

<div class="container">
    <h4 class="light">Модерация достижений</h4>
    <?php if(count($progress) > 0) : ?>
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
        <?php foreach($progress as $item) : ?>
            <div class="card horizontal <?php if($item->complete == 0) : ?>grey<?php else: ?>green<?php endif?> lighten-4 hoverable">
                <?php $image = Yii::$app->request->baseUrl . '/images/achievements/'. ($item->image != '' ? $item->image : 'default.jpg'); ?>
                <div class="card-image no-img_horizontal" style="background-image: url(<?= $image ?>)">
                    <a href="<?= Url::to(['achievements/edit', 'id' => $item->ach_id]) ?>"></a>
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <div class="card-title">
                            <a class="black-text" href="<?= Url::to(['site/profile', 'id' => $item->uid]) ?>">[<?= $item->u_company ?>] <?= $item->u_nickname ?></a>
                            - <a class="black-text" href="<?= Url::to(['achievements/edit', 'id' => $item->ach_id]) ?>"><?= $item->title ?></a></div>
                        <p><?= $item->description ?></p>
                        <p><a target="_blank" href="<?=Yii::$app->request->baseUrl?>/images/achievements/progress/<?= $item->proof ?>" class="fs17">СМОТРЕТЬ СКРИНШОТ</a></p>
                    </div>
                    <?php if($item->complete == 0) : ?>
                        <div class="card-action">
                            <a href="<?= Url::to(['achievements/apply', 'id' => $item->id]) ?>" onclick="return confirm('Одобрить?')">
                                <i class="material-icons notranslate to-text">done</i>Одобрить
                            </a>
                            <a href="<?= Url::to(['achievements/deny', 'id' => $item->id]) ?>" onclick="return confirm('Запись будет удалена безвозвратно. Уверены?')">
                                <i class="material-icons notranslate to-text">clear</i>Отклонить
                            </a>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
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
    <?php else: ?>
        <h5 class="light">Нет достижений для модерации</h5>
    <?php endif ?>
</div>