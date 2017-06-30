<?php

use yii\helpers\Url;
use app\models\User;;
use yii\widgets\LinkPager;

$this->title = 'Трейлеры - Volvo Trucks';
?>

<div class="container row">
    <?php foreach ($trailers as $trailer): ?>
        <div class="col l6 m6 s12">
            <div class="card grey lighten-4">
                <div class="card-image">
                    <img class="materialboxed" src="<?= Yii::$app->request->baseUrl ?>/images/trailers/<?= $trailer->picture ?>" alt="">
                </div>
                <div class="card-content">
                    <h5 class="light"><?=  $trailer->name ?></h5>
                    <span><?= $trailer->description ?></span>
                </div>
                <?php if(User::isAdmin()): ?>
                    <div class="card-action">
                        <a href="<?= Url::to(['site/trailers', 'id' => $trailer->id, 'action' => 'edit']) ?>">Редактировать</a>
                    </div>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach;
    if(\app\models\User::isAdmin()) : ?>
        <div class="fixed-action-btn">
            <a href="<?=Url::to(['site/trailers', 'action' => 'add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
        </div>
    <?php endif; ?>
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