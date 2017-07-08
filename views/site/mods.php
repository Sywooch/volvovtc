<?php

use yii\helpers\Url;

$this->title = 'Модификации для TruckersMP - Volvo Trucks';

?>

<div class="container">
    <div class="card grey lighten-4">
        <div class="card-image no-img" style="background-image: url(assets/img/mods/mods-main.jpg)">
            <span class="card-title text-shadow">Модификации для TruckersMP</span>
        </div>
        <div class="card-content row">
            <div class="row">
                <div class="col l6 s12 game-mods center-align">
                    <h6>МОДЫ ДЛЯ ETS2</h6>
                    <ul>

                        <li>
                            <a href="<?=Url::to([
                                'site/modifications',
                                'game' => 'ets',
                                'category' => 'trucks'
                            ])?>" class="btn indigo darken-3 waves-effect waves-light">
<!--                                <img src="--><?//=Yii::$app->request->baseUrl?><!--/assets/img/mods/mods-trucks.jpg" class="responsive-img" alt="Тягачи и аксессуары">-->
                                Тягачи и аксессуары
                            </a>
                        </li>
                        <li>
                            <a href="<?=Url::to([
                                'site/modifications',
                                'game' => 'ets',
                                'category' => 'trailers',
                                'subcategory' => 'machinery'
                            ])?>" class="btn indigo darken-3 waves-effect waves-light">Прицепы
<!--                                <img src="--><?//=Yii::$app->request->baseUrl?><!--/assets/img/mods/mods-trailers.jpg" class="responsive-img" alt="Прицепы">-->
                            </a>
                        </li>
                        <li>
                            <a href="<?=Url::to([
                                'site/modifications',
                                'game' => 'ets',
                                'category' => 'schwarzmullers',
                                'subcategory' => 'machinery'
                            ])?>" class="btn indigo darken-3 waves-effect waves-light">Schwarzmüller
<!--                                <img src="--><?//=Yii::$app->request->baseUrl?><!--/assets/img/mods/mods-schwarz.jpg" class="responsive-img" alt="Schwarzmüller">-->
                            </a>
                        </li>
                        <li>
                            <a href="<?=Url::to([
                                'site/modifications',
                                'game' => 'ets',
                                'category' => 'coloredtrailers',
                                'subcategory' => 'containerscurtainsliders'
                            ])?>" class="btn indigo darken-3 waves-effect waves-light">Цветные прицепы
<!--                                <img src="--><?//=Yii::$app->request->baseUrl?><!--/assets/img/mods/mods-colored-trailers.jpg" class="responsive-img" alt="">-->
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col l6 s12 flex game-mods center-align">
                    <div class="categories">
                        <h6>МОДЫ ДЛЯ ATS</h6>
                        <ul>
                            <li>
                                <a href="<?=Url::to([
                                    'site/modifications',
                                    'game' => 'ats',
                                    'category' => 'trucks'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light z-depth-3">Тягачи и аксессуары
<!--                                    <img src="--><?//=Yii::$app->request->baseUrl?><!--/assets/img/mods/mods-trucks-ats.jpg" class="responsive-img" alt="">-->
                                </a>
                            </li>
                            <li>
                                <a href="<?=Url::to([
                                    'site/modifications',
                                    'game' => 'ats',
                                    'category' => 'trailers',
                                    'subcategory' => 'machinery'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light z-depth-3">Прицепы
<!--                                    <img src="--><?//=Yii::$app->request->baseUrl?><!--/assets/img/mods/mods-trailers-ats.jpg" class="responsive-img" alt="">-->
                                </a></li>
                            <li>
                                <a href="<?=Url::to([
                                    'site/modifications',
                                    'game' => 'ats',
                                    'category' => 'coloredtrailers',
                                    'subcategory' => 'containerscurtainsliders'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light z-depth-3">Цветные прицепы
<!--                                    <img src="--><?//=Yii::$app->request->baseUrl?><!--/assets/img/mods/mods-colored-trailers-ats.jpg" class="responsive-img" alt="">-->
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
<!--            <div class="mod-order valign-wrapper">-->
<!--                <a target="_blank" href="https://vk.com/im?sel=34358094" class="btn-floating btn-large green darken-3 waves-effect waves-light tooltipped"  data-position="bottom" data-delay="50" data-tooltip="Заказать мод">-->
<!--                    <i class="material-icons">note_add</i>-->
<!--                </a>-->
<!--                <p><i>В мультиплеере будут работать только те моды, которые используюют оригинальные файлы игры</i></p>-->
<!--            </div>-->
            <p><b>Все модификации для мультиплеера нужно устанавливать и применять в одиночной игре, как и все стандартные модификации.
                Предварительно сохранив игровой процесс, можно заходить в мультиплеер, игнорируя предупреждения игры.</b></p>
            <h3>Личный прицеп</h3>
            <div class="row">
                <div class="col l4 s12">
                    <img class="responsive-img" src="<?=Yii::$app->request->baseUrl?>/assets/img/mods/tedit.png">
                </div>
                <div class="col l8 s12">
                    <ul class="collapsible" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header">Euro Truck Simulator 2</div>
                            <div class="collapsible-body">
                                <p>Для корректной работы программы нужно открыть <b>config.cfg</b> через текстовый редактор и
                                    в параметре <b>g_save_format</b> изменить значение <b>0</b> на <b>2</b>.</p>
                                <h6><a href="http://sharemods.com/5ndssisr2gn1/TEDIT_v4.11.rar.html" target="_blank">Скачать TEDIT v4.11</a></h6>
                                <div class="video-container">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/XOYwF48E_PU?rel=0" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header">American Truck Simulator</div>
                            <div class="collapsible-body">
                                <p>Для корректной работы программы нужно открыть <b>config.cfg</b> через текстовый редактор и
                                    в параметре <b>g_save_format</b> изменить значение <b>0</b> на <b>2</b>.</p>
                                <h6><a href="https://yadi.sk/d/o2cWIbwW3EDnbP" target="_blank">Скачать TEDIT v2.8.2</a></h6>
                                <div class="video-container">
                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/TwS63ASk36E?rel=0" frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php if(\app\models\User::isAdmin()): ?>
        <div class="fixed-action-btn">
            <a href="<?=Url::to(['site/modifications', 'action' => 'add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
        </div>
    <?php endif ?>
</div>