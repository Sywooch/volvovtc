<?php

use yii\helpers\Url;
use app\models\User;;
use yii\widgets\LinkPager;

$this->title = 'Трейлеры - Volvo Trucks';
?>

<div class="container row">
    <div class="col s12">
        <div class="card-panel grey lighten-4 search">
            <form method="get">
                <div class="input-field">
                    <button type="submit" class="prefix user-search waves-effect circle">
                        <i class="material-icons">search</i>
                    </button>
                    <input placeholder="Искать трейлер" type="text" name="q" <?php if(Yii::$app->request->get('q')): ?>value="<?= Yii::$app->request->get('q') ?>"<?php endif ?>>
                    <?php if(Yii::$app->request->get('q')) : ?>
                        <a href="<?= Url::to(['site/trailers']) ?>" class="search-reset waves-effect circle">
                            <i class="material-icons">clear</i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
    <h5 class="light col s12">Всего <?= $total ?></h5>
    <?php foreach ($trailers as $key => $trailer): ?>
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
                        <a href="<?= Url::to(['site/trailers', 'id' => $trailer->id, 'action' => 'delete']) ?>" onclick="return confirm('Удалить трейлер?')">Удалить</a>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <?php if($key % 2 != 0) : ?>
            <div class="clearfix"></div>
        <?php endif ?>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <?php if(\app\models\User::isAdmin()) : ?>
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