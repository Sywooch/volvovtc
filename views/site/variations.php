<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Вариации тягачей - Volvo Trucks';

?>

<div class="container">
    <div class="col hide-on-med-and-down m3 l2 fixed-right">
        <ul class="section table-of-contents">
            <li><a href="#1">Вариация №1</a></li>
            <li><a href="#2">Вариация №2</a></li>
            <li>
                <a href="#3">Вариация №3</a>
                <ul class="browser-default">
                    <li><a href="#mercedes">Mercedes</a></li>
                    <li><a href="#scania">Scania</a></li>
                    <li><a href="#daf">DAF</a></li>
                    <li><a href="#renault">Renault</a></li>
                    <li><a href="#man">MAN</a></li>
                    <li><a href="#iveco">Iveco</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div id="1" class="scrollspy">
        <h5>Вариация №1</h5>
        <div class="card">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var1_1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var1_2.jpg">
                </div>
                <span class="card-title text-shadow">Volvo FH<br>Volvo FH Classic</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body">
                            <ul class="force-list-style">
                                <li>Пользовательский цвет - металлик (Черный)</li>
                                <li>Решетка двух видов (Volvo FH)</li>
                                <li>Колеса. Разрешаются все, кроме цветных</li>
                                <li>Покрышки. Разрешаются только от черных до белых оттенков</li>
                                <li>Защита бампера - Samurai (по желанию)</li>
                                <li>Козырек - заводской (по желанию)</li>
                                <li>Боковая юбка (по желанию)</li>
                                <li>Остальное все запрещено</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="2" class="scrollspy">
        <h5>Вариация №2</h5>
        <div class="card">
            <div class="card-image">
                <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var2.jpg">
                <span class="card-title text-shadow">Volvo FH Classic</span>
            </div>
            <div class="card-content">
                <span class="grey-text">Данный грузовик предназначен для крупногабаритных и насыпных грузов.</span>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body list-style-default">
                            <ul>
                                <li>Кабина: Globetrotter (средняя)</li>
                                <li>Шасси: 6х2 / 6х2 подъемная ось / 6х4 (на выбор)</li>
                                <li>Цвет: Белый (просто белый, не металлик)</li>
                                <li>Лайтбар: Mirage (первый)</li>
                                <li>Два маячка по бокам</li>
                                <li>Козырек: заводской</li>
                                <li>Зеркала / ручки в цвет кузова</li>
                                <li>Колеса
                                    <ul>
                                        <li>Передние - Dark Silver</li>
                                        <li>Задние - Eastern Eagle</li>
                                    </ul>
                                </li>
                                <li>Тюнинг колес с DLC Wheel Tuning Pack
                                    <ul>
                                        <li>Диск
                                            <ul>
                                                <li>Передний - Elite Rider</li>
                                                <li>Задний - Standard Gloss</li>
                                            </ul>
                                        </li>
                                        <li>Коллпак
                                            <ul>
                                                <li>Передний - Pacific</li>
                                                <li>Задний - Pacific</li>
                                            </ul>
                                        </li>
                                        <li>Ступица
                                            <ul>
                                                <li>Передняя - Absolute Fury</li>
                                                <li>Задняя - Standard</li>
                                            </ul>
                                        </li>
                                        <li>Гайки
                                            <ul>
                                                <li>Передние - Standard</li>
                                                <li>Задние - Standard</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>Покрышки: Elemental</li>
                                <li>Остальное все запрещено, кроме табличек и салона</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="3" class="scrollspy">
        <h5>Вариация №3</h5>
        <div id="mercedes" class="card scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_merc1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_merc2.jpg">
                </div>
                <span class="card-title text-shadow">Mercedes-Benz Actros MP3<br>Mercedes-Benz Actros MP4</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body">
                            <ul class="force-list-style">
                                <li>Пользовательский цвет - металлик (Черный)</li>
                                <li>Колеса. Разрешаются все, кроме цветных</li>
                                <li>Покрышки. Разрешаются только от черных до белых оттенков</li>
                                <li>Защита бампера - Samurai (по желанию)</li>
                                <li>Аксессуары - Katana (MB Actros MP4) (по желанию)</li>
                                <li>Козырек - заводской (по желанию)</li>
                                <li>Боковая юбка (по желанию)</li>
                                <li>Остальное все запрещено</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="scania" class="card scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/8">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_scan1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_scan2.jpg">
                </div>
                <span class="card-title text-shadow">Scania R<br>Scania Streamline</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body">
                            <ul class="force-list-style">
                                <li>Пользовательский цвет - металлик (Черный)</li>
                                <li>Колеса. Разрешаются все, кроме цветных</li>
                                <li>Покрышки. Разрешаются только от черных до белых оттенков</li>
                                <li>Защита бампера - Samurai (по желанию)</li>
                                <li>Козырек - заводской (по желанию)</li>
                                <li>Боковая юбка (по желанию)</li>
                                <li>Mighty Griffin Tuning Pack
                                    <ul>
                                        <li>Запрещено устанавливать:
                                            <ul>
                                                <li>Аксессуары - защита от камней</li>
                                                <li>Кенгурятник Thor</li>
                                            </ul>
                                        </li>
                                        <li>остальное из данного DLC можно устанавливать все</li>
                                    </ul>
                                </li>
                                <li>Остальное все запрещено</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="daf" class="card scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="160/75">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_daf1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_daf2.jpg">
                </div>
                <span class="card-title text-shadow">DAF XF105<br>DAF XF Euro 6</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body">
                            <ul class="force-list-style">
                                <li>Пользовательский цвет - металлик (Черный)</li>
                                <li>Колеса. Разрешаются все, кроме цветных</li>
                                <li>Покрышки. Разрешаются только от черных до белых оттенков</li>
                                <li>Защита бампера - Samurai (по желанию)</li>
                                <li>Козырек - заводской (по желанию)</li>
                                <li>Боковая юбка (по желанию)</li>
                                <li>Остальное все запрещено</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="renault" class="card scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ren1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ren2.jpg">
                </div>
                <span class="card-title text-shadow">Renault Premium<br>Renault Magnum</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body">
                            <ul class="force-list-style">
                                <li>Пользовательский цвет - металлик (Черный)</li>
                                <li>Колеса. Разрешаются все, кроме цветных</li>
                                <li>Покрышки. Разрешаются только от черных до белых оттенков</li>
                                <li>Защита бампера - Samurai (по желанию)</li>
                                <li>Козырек - заводской (по желанию)</li>
                                <li>Боковая юбка (по желанию)</li>
                                <li>Остальное все запрещено</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="man" class="card scrollspy">
            <div class="card-image">
                <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_man.jpg">
                <span class="card-title text-shadow">MAN TGX</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body list-style-default">
                            <ul>
                                <ul class="force-list-style">
                                    <li>Пользовательский цвет - металлик (Черный)</li>
                                    <li>Колеса. Разрешаются все, кроме цветных</li>
                                    <li>Покрышки. Разрешаются только от черных до белых оттенков</li>
                                    <li>Защита бампера - Samurai (по желанию)</li>
                                    <li>Козырек - заводской (по желанию)</li>
                                    <li>Боковая юбка (по желанию)</li>
                                    <li>Остальное все запрещено</li>
                                </ul>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="iveco" class="card scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ive1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ive2.jpg">
                </div>
                <span class="card-title text-shadow">Iveco Stralis<br>Iveco HI-WAY</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body">
                            <ul class="force-list-style">
                                <li>Пользовательский цвет - металлик (Черный)</li>
                                <li>Колеса. Разрешаются все, кроме цветных</li>
                                <li>Покрышки. Разрешаются только от черных до белых оттенков</li>
                                <li>Защита бампера - Samurai (по желанию)</li>
                                <li>Козырек - заводской (по желанию)</li>
                                <li>Боковая юбка (по желанию)</li>
                                <li>Остальное все запрещено</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>