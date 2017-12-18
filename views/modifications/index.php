<?php

use yii\helpers\Url;

$this->title = 'Модификации для TruckersMP - Volvo Trucks';
?>

<div class="parallax-container parallax-shadow hide-on-small-only" style="height: 400px;">
    <div class="container">
        <h4 class="parallax-title light white-text text-shadow">Модификации для TruckersMP</h4>
    </div>
    <div class="parallax"><img src="<?=Yii::$app->request->baseUrl?>/assets/img/mods/mods-main.jpg"></div>
</div>

<div class="container">
    <div class="row flex">
        <div class="game-mods">
            <div class="card horizontal grey lighten-4">
                <div class="card-image game-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/assets/img/mods/ets2.jpg)"></div>
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title center-align">МОДЫ ДЛЯ ETS2MP</span>
                        <ul class="center-align categories">
                            <li>
                                <a href="<?=Url::to([
                                    'modifications/category',
                                    'game' => 'ets',
                                    'category' => 'trucks'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light">Тягачи и аксессуары</a>
                            </li>
                            <li>
                                <a href="<?=Url::to([
                                    'modifications/category',
                                    'game' => 'ets',
                                    'category' => 'trailers',
                                    'subcategory' => 'machinery'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light">Прицепы</a>
                            </li>
                            <li>
                                <a href="<?=Url::to([
                                    'modifications/category',
                                    'game' => 'ets',
                                    'category' => 'coloredtrailers',
                                    'subcategory' => 'containerscurtainsliders'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light">Цветные прицепы</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="game-mods">
            <div class="card horizontal grey lighten-4">
                <div class="card-stacked">
                    <div class="card-content">
                        <span class="card-title center-align">МОДЫ ДЛЯ ATSMP</span>
                        <ul class="center-align categories">
                            <li>
                                <a href="<?=Url::to([
                                    'modifications/category',
                                    'game' => 'ats',
                                    'category' => 'trucks'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light z-depth-3">Тягачи и аксессуары</a>
                            </li>
                            <li>
                                <a href="<?=Url::to([
                                    'modifications/category',
                                    'game' => 'ats',
                                    'category' => 'trailers',
                                    'subcategory' => 'refrigerated'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light z-depth-3">Прицепы</a>
                            </li>
                            <li>
                                <a href="<?=Url::to([
                                    'modifications/category',
                                    'game' => 'ats',
                                    'category' => 'coloredtrailers',
                                    'subcategory' => 'containerscurtainsliders'
                                ])?>" class="btn indigo darken-3 waves-effect waves-light z-depth-3">Цветные прицепы</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-image game-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/assets/img/mods/ats.jpg)"></div>
            </div>
        </div>
    </div>
    <div class="row center">
        <a href="<?= Url::to(['modifications/all']) ?>" class="center btn-flat">Список всех модификаций</a>
    </div>
    <p class="grey-text center-align"><b>Все модификации для мультиплеера нужно устанавливать и применять в одиночной игре, как и все стандартные модификации.
            Предварительно сохранив игровой процесс, можно заходить в мультиплеер, игнорируя предупреждения игры.</b></p>

    <div class="card horizontal grey lighten-4">
        <div class="card-image tedit-img hide-on-med-and-down" style="background-image: url(<?=Yii::$app->request->baseUrl?>/assets/img/mods/tedit.png)"></div>
        <div class="card-stacked">
            <div class="card-content">
                <span class="card-title">Личный прицеп</span>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons">ondemand_video</i>Euro Truck Simulator 2</div>
                        <div class="collapsible-body">
                            <p>Для корректной работы программы нужно открыть <b>config.cfg</b> через текстовый редактор и
                                в параметре <b>g_save_format</b> изменить значение <b>0</b> на <b>2</b>.</p>
                            <h6><a href="<?= Yii::$app->request->baseUrl ?>/TEDIT_4_18_5_1_ets.zip" target="_blank">Скачать TEDIT v4.18.5.1</a></h6>
                            <div class="video-container">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/XOYwF48E_PU?rel=0" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons">ondemand_video</i>American Truck Simulator</div>
                        <div class="collapsible-body">
                            <p>Для корректной работы программы нужно открыть <b>config.cfg</b> через текстовый редактор и
                                в параметре <b>g_save_format</b> изменить значение <b>0</b> на <b>2</b>.</p>
                            <h6><a href="<?= Yii::$app->request->baseUrl ?>/TEDIT_4_18_5_1_ats.zip" target="_blank">Скачать TEDIT v4.18.5.1</a></h6>
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