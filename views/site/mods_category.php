<?php

use yii\helpers\Url;

$this->title = $category->title . ' - '.$subcategory->title . ' - Volvo Trucks'; ?>

<div class="container">
    <div class="card grey lighten-4">
        <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/mods/categories/<?=$category->picture?>)">
            <span class="card-title text-shadow"><?= $category->title ?></span>
        </div>
        <div class="card-content row">
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
                            ]) ?>" class="btn indigo darken-3 <?= $class ?> waves-effect waves-light"><?= $subcat->title ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>
            <?php if($mods):
                $i = 1;
                foreach ($mods as $mod): ?>
                    <div class="row mod <?php if($mod->visible == '0'): ?>grey lighten-2<?php endif ?>">
                        <div class="mod-number col l1 s1">
                            <h5><?= $i++ ?></h5>
                        </div>
                        <div class="mod-img col l4 s11">
                            <img class="materialboxed z-depth-3" width="100%" src="<?=Yii::$app->request->baseUrl?>/images/mods/<?= $mod->picture ?>">
                        </div>
                        <div class="mod-info col l4 s12">
                            <div class="mod-title">
                                <span><?= $mod->title ?></span>
                            </div>
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
                        <div class="mod-links col l3 s12">
                            <ul>
                                <li><a href="<?= Yii::$app->request->baseUrl.'/mods/'.$mod->game.'/'.$mod->file_name
                                    ?>" class="btn indigo darken-3 waves-effect waves-light">Скачать
                                        <i class="material-icons right">get_app</i>
                                    </a>
                                </li>
                                <?php if($mod->yandex_link) : ?>
                                    <li><a href="<?= $mod->yandex_link ?>" class="btn-flat waves-effect">Яндекс.Диск</a></li>
                                <?php endif ?>
                                <?php if($mod->gdrive_link) : ?>
                                    <li><a href="<?= $mod->gdrive_link ?>" class="btn-flat waves-effect">Google Drive</a></li>
                                <?php endif ?>
                                <?php if($mod->mega_link) : ?>
                                    <li><a href="<?= $mod->mega_link ?>" class="btn-flat waves-effect">MEGA</a></li>
                                <?php endif ?>
                            </ul>
                            <?php if(\app\models\User::isAdmin()) : ?>
                                <div class="mod-actions center">
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
                <?php endforeach;
            else: ?>
                <h5>Пока что нет модов в этой категории =(</h5>
            <?php endif ?>
            <?php if(\app\models\User::isAdmin()): ?>
                <div class="fixed-action-btn">
                    <a href="<?=Url::to(['site/modifications', 'action' => 'add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>