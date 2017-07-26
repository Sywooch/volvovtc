<?php

use yii\helpers\Url;

$this->title = $category->title . ' - '.$subcategory->title . ' - Volvo Trucks'; ?>

<div class="parallax-container" style="height: 400px;">
    <div class="container">
        <h4 class="parallax-title light white-text text-shadow"><?= $category->title ?></h4>
    </div>
    <div class="parallax"><img src="<?=Yii::$app->request->baseUrl?>/images/mods/categories/<?=$category->picture?>"></div>
</div>
<div class="container">
    <?php if(count($all_subcategories) > 1) : ?>
        <div class="row subcategories">
            <?php foreach($all_subcategories as $key => $subcat) :
                if($subcategory->name == $subcat->name) $class = 'disabled';
                else $class = ''; ?>
                <div class="col <?php if($key != 8): ?>l3 m4<?php endif ?> s12">
                    <a href="<?= Url::to([
                        'site/modifications',
                        'game' => $category->game,
                        'category' => $category->name,
                        'subcategory' => $subcat->name
                    ]) ?>" class="btn-flat <?= $class ?> waves-effect waves-light"><?= $subcat->title ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif ?>
        <?php if($mods):
            $i = 1; ?>
            <div class="row">
            <?php foreach ($mods as $key => $mod):
                $trailer_data = \app\models\Mods::getTrailerData($mod);
                $class = $mod->visible == '1' ? 'grey' : 'yellow' ?>
                <div class="col l6 s12">
                    <div class="card <?= $class ?> lighten-4 hoverable">
                        <div class="card-image mod-img">
                            <img class="materialboxed" width="100%" src="<?=Yii::$app->request->baseUrl?>/images/<?= $trailer_data['image'] ?>">
                        </div>
                        <div class="card-content mod-info">
                            <h6 class="fs17 mod-title"><?= $mod->title ?></h6>
                            <?php if($mod->description) : ?>
                                <div class="mod-description">
                                    <span><?= $mod->description ?></span>
                                </div>
                            <?php endif ?>
                            <?php if($mod->warning) : ?>
                                <div class="mod-warning">
                                    <span>(<?= $mod->warning ?>)</span>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="card-action mod-links">
                            <a href="<?= Yii::$app->request->baseUrl.'/mods/'.$mod->game.'/'.$mod->file_name
                            ?>" class="waves-effect">Скачать
                                <i class="material-icons left">get_app</i>
                            </a>
                            <?php if($mod->yandex_link) : ?>
                                <a href="<?= $mod->yandex_link ?>" class="waves-effect">Яндекс.Диск</a>
                            <?php endif ?>
                            <?php if($mod->gdrive_link) : ?>
                                <a href="<?= $mod->gdrive_link ?>" class="waves-effect">Google Drive</a>
                            <?php endif ?>
                            <?php if($mod->mega_link) : ?>
                                <a href="<?= $mod->mega_link ?>" class="waves-effect">MEGA</a>
                            <?php endif ?>
                            <?php if(\app\models\User::isAdmin()) : ?>
                                <div class="mod-actions">
                                    <a href="<?=Url::to(['site/modifications',
                                        'id' => $mod->id,
                                        'action' => 'edit'])?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Редактировать">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <a href="<?=Url::to(['site/modifications',
                                        'id' => $mod->id,
                                        'action' => $mod->visible == 1 ? 'hide' : 'show'])
                                    ?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Спрятать/Показать">
                                        <i class="material-icons"><?= $mod->visible === 1 ? 'visibility' : 'visibility_off' ?></i>
                                    </a>
                                    <a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/modifications',
                                        'id' => $mod->id,
                                        'action' => 'delete'])
                                    ?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Удалить">
                                        <i class="material-icons">delete</i>
                                    </a>
                                    <a href="<?=Url::to(['site/modifications',
                                        'id' => $mod->id,
                                        'action' => 'sortdown'
                                    ]) ?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Переместить ниже">
                                        <i class="material-icons">keyboard_arrow_down</i>
                                    </a>
                                    <a href="<?=Url::to(['site/modifications',
                                        'id' => $mod->id,
                                        'action' => 'sortup'
                                    ]) ?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Переместить выше">
                                        <i class="material-icons">keyboard_arrow_up</i>
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <?php if($key % 2 != 0) : ?>
                    <div class="clearfix"></div>
                <?php endif ?>
            <?php endforeach;?>
            </div>
        <?php else: ?>
            <h5 class="light">Пока что нет модов в этой категории =(</h5>
        <?php endif ?>
        <?php if(\app\models\User::isAdmin()): ?>
            <div class="fixed-action-btn">
                <a href="<?=Url::to(['site/modifications', 'action' => 'add', 'cat' => $_GET['game'].'/'.$_GET['category'].'/'.Yii::$app->request->get('subcategory')])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
            </div>
        <?php endif ?>
</div>