<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = 'Новости - Volvo Trucks';

?>

<div class="container">
    <?php foreach($news as $item) : ?>
    <div class="card <?php if($item->visible == '1') :?>grey<?php else :?>yellow<?php endif ?> lighten-4 hoverable">
        <div class="card-image">
            <div class="fotorama" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/9">
                <?php foreach(unserialize($item->picture) as $img) : ?>
                    <img src="<?= Yii::$app->request->baseUrl ?>/images/news/<?= $img ?>" alt="">
                <?php endforeach; ?>
            </div>
            <p class="gray-text card-date"><?= \app\controllers\SiteController::getRuDate($item->date) ?></p>
            <span class="card-title text-shadow"></span>
        </div>
        <div class="card-content">
            <h4><?= $item->title ?></h4>
            <p><?= $item->subtitle ?></p>
        </div>
        <?php if($item->text || !Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
        <div class="card-action">
            <?php if($item->text) : ?>
                <a href="<?=Url::to(['site/news', 'id' => $item->id])?>">ЧИТАТЬ ПОЛНОСТЬЮ</a>
            <?php endif; ?>
            <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
                <a href="<?=Url::to([
                        'site/news',
                        'id' => $item->id,
                        'action' => 'sortdown'
                ]) ?>" class="right tooltipped" data-position="bottom" data-tooltip="Переместить ниже">
                        <i class="material-icons notranslate">keyboard_arrow_down</i>
                </a>
                <a href="<?=Url::to([
                        'site/news',
                        'id' => $item->id,
                        'action' => 'sortup'
                ]) ?>" class="right tooltipped" data-position="bottom" data-tooltip="Переместить выше">
                        <i class="material-icons notranslate">keyboard_arrow_up</i>
                </a>
                <a href="<?=Url::to([
                        'site/news',
                        'id' => $item->id,
                        'action' => $item->visible == 1 ? 'hide' : 'show'
                ]) ?>" class="right tooltipped" data-position="bottom" data-tooltip="Спрятать/Показать">
                        <i class="material-icons notranslate"><?= $item->visible === 1 ? 'visibility' : 'visibility_off' ?></i>
                </a>
                <a onclick='return confirm("Удалить?")' href="<?=Url::to([
                        'site/news',
                        'id' => $item->id,
                        'action' => 'delete'])
                    ?>" class="right tooltipped" data-position="bottom" data-tooltip="Удалить">
                        <i class="material-icons notranslate">delete</i>
                </a>
                <a href="<?=Url::to([
                    'site/news',
                    'id' => $item->id,
                    'action' => 'edit'
                ])?>" class="right tooltipped" data-position="bottom" data-tooltip="Редактировать" ><i class="material-icons notranslate">edit</i>
                </a>
            <?php endif; ?>
            <div class="clearfix"></div>
        </div>
        <?php endif; ?>
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
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
        <div class="fixed-action-btn">
            <a href="<?=Url::to(['site/news', 'action' => 'add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons notranslate">add</i></a>
        </div>
    <?php endif; ?>
</div>