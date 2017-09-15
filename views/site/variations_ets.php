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
    <div class="row" style="margin-top: 20px;">
        <?php $game = Yii::$app->request->get('game'); ?>
        <div class="col m6 s12">
            <a href="<?= Url::to(['site/variations', 'game' => 'ets2']) ?>" class="btn-flat waves-effect right<?php if($game != 'ats'): ?> disabled<?php endif ?>">
                Отделение ETS2
            </a>
        </div>
        <div class="col m6 s12">
            <a href="<?= Url::to(['site/variations', 'game' => 'ats']) ?>" class="btn-flat waves-effect left<?php if($game == 'ats'): ?> disabled<?php endif ?>">
                Отделение ATS
            </a>
        </div>
    </div>
    <div id="1" class="scrollspy">
        <h5>Вариация №1</h5>
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть общий тюнинг</div>
                <div class="collapsible-body grey lighten-4">
                    <ul class="force-list-style">
                        <li>Кузов, шасси, двигатель, трансмиссия - на выбор</li>
                        <li>Пользовательский цвет - черный металлик</li>
                        <li>Диски, ступицы, гайки, колпаки разрешается устанавливать: стандартные, хромированные и крашенные (от белых к черным оттенкам)</li>
                        <li>Шины разрешается красить только от черных до белых оттенков</li>
                        <li>Защита бампера - Samurai (по желанию)</li>
                        <li>Козырек - заводской (по желанию)</li>
                        <li>Боковая юбка, переднее зеркало - по желанию</li>
                        <li>Основные зеркала, дверные ручки, ступеньки дверей - на ваш выбор</li>
                        <li>Разрешается устанавливать элементы тюнинга добавляемые в DLC National Window Flags и любые аксессуары в кабину</li>
                        <li>Остальное все запрещено</li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="card grey lighten-4">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var1_1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var1_2.jpg">
                </div>
                <span class="card-title text-shadow">Volvo FH<br>Volvo FH Classic</span>
            </div>
            <div class="card-content row">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Volvo FH Classic</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Нет дополнительного тюнинга</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Volvo FH</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Разрешается устанавливать решетку радиатора двух видов</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="2" class="scrollspy">
        <h5>Вариация №2</h5>
        <div class="card grey lighten-4">
            <div class="card-image">
                <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var2.jpg">
                <span class="card-title text-shadow">Volvo FH Classic</span>
            </div>
            <div class="card-content">
                <span class="grey-text">Данный грузовик предназначен для крупногабаритных и насыпных грузов.</span>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть тюнинг</div>
                        <div class="collapsible-body grey lighten-4 list-style-default">
                            <ul>
                                <li>Кабина: Sleeper (малая)</li>
                                <li>Шасси: 6х2 / 6х2 подъемная ось / 6х4 (на выбор)</li>
                                <li>Цвет: Белый (просто белый, не металлик)</li>
                                <li>Лайтбар: Sting</li>
                                <li>Два маячка по бокам</li>
                                <li>Козырек: заводской</li>
                                <li>Зеркала / ручки в цвет кузова</li>
                                <li>Колеса из 1 вариации</li>
                                <li>Остальное все запрещено, кроме табличек, DLC National Window Flags и любых аксессуаров в кабину
                                    <ul>
                                        <li>Разрешается установить три желтых лампочки по середине на лайтбаре</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="3" class="scrollspy">
        <h5>Вариация №3</h5>
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть общий тюнинг</div>
                <div class="collapsible-body grey lighten-4">
                    <ul class="force-list-style">
                        <li>Кузов, шасси, двигатель, трансмиссия - на выбор</li>
                        <li>Пользовательский цвет - черный металлик</li>
                        <li>Диски, ступицы, гайки, колпаки разрешается устанавливать: стандартные, хромированные и крашенные (от белых к черным оттенкам)</li>
                        <li>Шины разрешается красить только от черных до белых оттенков</li>
                        <li>Защита бампера - Samurai (по желанию)</li>
                        <li>Козырек - заводской (по желанию)</li>
                        <li>Боковая юбка, переднее зеркало - по желанию</li>
                        <li>Основные зеркала, дверные ручки, ступеньки дверей - на ваш выбор</li>
                        <li>Разрешается устанавливать элементы тюнинга добавляемые в DLC National Window Flags и любые аксессуары в кабину</li>
                        <li>Остальное все запрещено</li>
                    </ul>
                </div>
            </li>
        </ul>
        <div id="mercedes" class="card scrollspy grey lighten-4">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_merc1.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_merc2.jpg">
                </div>
                <span class="card-title text-shadow">Mercedes-Benz Actros MP3<br>Mercedes-Benz Actros MP4</span>
            </div>
            <div class="card-content row">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Mercedes-Benz Actros MP3</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Нет дополнительного тюнинга</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Mercedes-Benz Actros MP4</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Разрешается устанавливать под юбку на места левого и правого выхлопов элемент Katana</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="scania" class="card grey lighten-4 scrollspy">
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
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Scania R</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Задний бампер, задние/передние брызговики на выбор</li>
                                <li>Металлический настил, верхний выхлоп по желанию</li>
                                <li>Окантовка ручек, ветровики по желанию</li>
                                <li>Дуги на решетке, решетка радиатора по желанию</li>
                                <li>Передняя маска, эмблема на выбор</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Scania Streamline</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Задний бампер, задние/передние брызговики на выбор</li>
                                <li>Металлический настил, верхний выхлоп по желанию</li>
                                <li>Окантовка ручек, ветровики по желанию</li>
                                <li>Дуги на решетке, решетка радиатора по желанию</li>
                                <li>Передняя маска, эмблема на выбор</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="daf" class="card grey lighten-4 scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="160/75">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_daf2.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_daf1.jpg">
                </div>
                <span class="card-title text-shadow">DAF XF105<br>DAF XF Euro 6</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для DAF XF105</div>
                        <div class="collapsible-body grey lighten-4 list-style-default">
                            <ul class="force-list-style">
                                <li>Задний бампер, задние/передние брызговики на выбор
                                    <ul>
                                        <li>На задний бампер разрешается устанавливать лампочки</li>
                                    </ul>
                                </li>
                                <li>Металлический настил, верхний выхлоп по желанию</li>
                                <li>Окантовка ручек, ветровики по желанию</li>
                                <li>Передняя маска, эмблема, рамка лобового стекла на выбор</li>
                                <li>Защита бампера: Samurai, Prospector краска/хром по желанию</li>
                                <li>Защита бампера: Samurai, Prospector краска/хром по желанию
                                    <ul>
                                        <li>На защиту бампера Prospector краска/хром разрешается устанавливать лампочки</li>
                                    </ul>
                                </li>
                                <li>Козырьки: заводской вариант, заводской вариант (краска) по желанию</li>
                                <li>На некоторые виды юбок разрешается устанавливать лампочки</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для DAF XF Euro 6</div>
                        <div class="collapsible-body grey lighten-4 list-style-default">
                            <ul class="force-list-style">
                                <li>Задний бампер, задние/передние брызговики на выбор
                                    <ul>
                                        <li>На задний бампер разрешается устанавливать лампочки</li>
                                    </ul>
                                </li>
                                <li>Металлический настил, верхний выхлоп по желанию</li>
                                <li>Окантовка ручек, ветровики по желанию</li>
                                <li>Передняя маска, эмблема, панель под эмблемой, рамка лобового стекла на выбор</li>
                                <li>Решетка радиатора по желанию</li>
                                <li>Защита бампера: Samurai, Pride краска/хром по желанию</li>
                                <li>Козырьки: заводской вариант, заводской вариант (краска),Locus (краска), cyclopean по желанию
                                    <ul>
                                        <li>На козырек Cyclopean разрешается устанавливать лампочки</li>
                                    </ul>
                                </li>
                                <li>На некоторые виды юбок разрешается устанавливать лампочки</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="renault" class="card grey lighten-4 scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ren2.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ren1.jpg">
                </div>
                <span class="card-title text-shadow">Renault Premium<br>Renault Magnum</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Renault Premium</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Нет дополнительного тюнинга</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Renault Magnum</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Нет дополнительного тюнинга</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="man" class="card grey lighten-4 scrollspy">
            <div class="card-image">
                <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_man.jpg">
                <span class="card-title text-shadow">MAN TGX</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для MAN TGX</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Нет дополнительного тюнинга</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="iveco" class="card grey lighten-4 scrollspy">
            <div class="card-image">
                <div class="fotorama fotorama-nav-right" data-max-width="100%" data-nav="thumbs" data-fit="cover" data-ratio="16/7">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ive2.jpg">
                    <img src="<?= Yii::$app->request->baseUrl ?>/assets/img/var3_ive1.jpg">
                </div>
                <span class="card-title text-shadow">Iveco Stralis<br>Iveco HI-WAY</span>
            </div>
            <div class="card-content">
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Iveco Stralis</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Нет дополнительного тюнинга</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">arrow_forward</i>Смотреть доп. тюнинг для Iveco HI-WAY</div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style">
                                <li>Нет дополнительного тюнинга</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>