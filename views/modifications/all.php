<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Моды для ETS2MP и ATSMP - Volvo Trucks' ?>

<div class="container">
    <div class="card-panel grey lighten-4 search">
        <form method="get">
            <div class="input-field">
                <button type="submit" class="prefix user-search waves-effect circle">
                    <i class="material-icons notranslate">search</i>
                </button>
                <input placeholder="Искать модификации" type="text" name="q" <?php if(Yii::$app->request->get('q')): ?>value="<?= Yii::$app->request->get('q') ?>"<?php endif ?>>
                <?php if(Yii::$app->request->get('q')) : ?>
                    <a href="<?= Url::to(['modifications/all']) ?>" class="search-reset waves-effect circle">
                        <i class="material-icons notranslate">clear</i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <div class="row">
        <h5 class="light col m6 s12">Всего найдено <?= $total ?></h5>
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'firstPageLabel' => 'Начало',
            'lastPageLabel' => 'Конец',
            'options' => [
                'class' => 'pagination right-align col m6 s12'
            ],
            'prevPageCssClass' => 'waves-effect',
            'pageCssClass' => 'waves-effect',
            'nextPageCssClass' => 'waves-effect',
            'activePageCssClass' => 'active waves-effect',
            'disabledPageCssClass' => 'disabled',
            'maxButtonCount' => 5
        ]) ?>
    </div>
    <?php foreach($mods as $mod) :
        if($mod->trailer){
            $mod->picture = 'trailers/' . $mod->tr_image;
        }else{
            $mod->picture = 'mods/' . $mod->picture;
        }
        $class = $mod->visible == '1' ? 'grey' : 'yellow'; ?>
        <div class="card horizontal <?= $class ?> lighten-4 hoverable">
            <div class="card-image no-img_horizontal"
				 style="background-image: url(<?= Yii::$app->request->baseUrl ?>/images/<?= $mod->picture ?>); min-width: 33%"></div>
            <div class="card-stacked">
                <div class="card-content">
                    <span class="card-title"><?= $mod->title ?></span>
                    <p><?= $mod->description ?></p>
                </div>
                <div class="card-action">
                    <a href="<?= Yii::$app->request->baseUrl.'/mods/'.$mod->game.'/'.$mod->file_name?>">Скачать
                        <i class="material-icons notranslate left">get_app</i>
                    </a>
                </div>
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
</div>
