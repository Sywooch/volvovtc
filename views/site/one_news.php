<?php

use yii\helpers\Url;

$this->title = $news->title . ' - Volvo Trucks';

?>
<div class="container">
    <div class="card grey lighten-4">
        <div class="card-image">
            <div class="fotorama" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/9">
                <?php foreach(unserialize($news->picture) as $img) : ?>
                    <img src="<?= Yii::$app->request->baseUrl ?>/images/news/<?= $img ?>">
                <?php endforeach; ?>
            </div>
        </div>
        <div class="card-content">
            <h4 class="card-title"><?= $news->title ?></h4>
            <h6><b><?= $news->subtitle ?></b></h6>
            <span><?= $news->text ?></span>
        </div>
    </div>
    <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
        <div class="fixed-action-btn vertical">
            <a href="<?=Url::to([
                'site/news',
                'id' => $news->id,
                'action' => 'edit'
            ])?>" class="btn-floating btn-large red tooltipped" data-position="left" data-tooltip="Редактировать">
                <i class="large material-icons">mode_edit</i>
            </a>
            <ul>
                <li>
                    <a href="<?=Url::to([
                        'site/news',
                        'id' => $news->id,
                        'action' => 'delete'
                    ])?>" class="btn-floating yellow darken-3 tooltipped" data-position="left" data-tooltip="Удалить" onclick='return confirm("Удалить?")'>
                        <i class="material-icons">delete</i>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::to([
                        'site/news',
                        'id' => $news->id,
                        'action' => $news->visible == '1' ? 'hide' : 'show'
                    ])?>" class="btn-floating green tooltipped" data-position="left" data-tooltip="<?= $news->visible == '1' ?
                        'Скрыть новость' : 'Сделать видимой' ?>">
                        <i class="material-icons"><?= $news->visible == '1' ? 'visibility_off' : 'visibility' ?></i>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>