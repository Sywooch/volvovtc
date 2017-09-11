<?php

use yii\helpers\Url;

$this->title = 'Конвои Volvo Trucks';
?>

<div class="container">
    <?php if($nearest_convoy) : ?>
    <h5 class="light">
        Ближайший конвой
        <span class="badge green white-text"><?= \app\controllers\SiteController::getRuDate($nearest_convoy->departure_time) ?></span>
    </h5>
    <div class="card grey lighten-4">
        <div class="card-image convoy-map">
			<?php if($nearest_convoy->picture_full): ?>
				<img src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?= $nearest_convoy->picture_small ?>?t=<?= time() ?>" class="materialboxed">
			<?php else: ?>
				<img src="<?=Yii::$app->request->baseUrl?>/assets/img/no_route.jpg">
			<?php endif ?>
            <span class="card-title text-shadow"><?= $nearest_convoy->title ?></span>
        </div>
        <div class="card-content">
            <span><?= $nearest_convoy->description ?></span>
            <div class="row flex-justify-center convoy-cities">
                <div class="start-place">
                    <div class="left-wrapper right center">
                        <h6>Старт:</h6>
                        <h4 class="convoy-city nowrap"><?=  $nearest_convoy->start_city ?></h4>
                        <h6 class="convoy-company nowrap"><?=  $nearest_convoy->start_company ?></h6>
                    </div>
                </div>
                <div class="center-align arrow">
                    <i class="material-icons large notranslate">arrow_forward</i>
                </div>
                <div class="finish-place">
                    <div class="right-wrapper left center">
                        <h6>Финиш:</h6>
                        <h4 class="convoy-city nowrap"><?=  $nearest_convoy->finish_city ?></h4>
                        <h6 class="convoy-company nowrap"><?=  $nearest_convoy->finish_company ?></h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l6 s12 flex-justify-center">
                    <div class="list-wrapper">
                        <ul class="fs17">
                            <li class="clearfix"><i class="material-icons left notranslate">event</i>
                                Дата: <b><?=  \app\controllers\SiteController::getRuDate($nearest_convoy->date) ?></b>
                            </li>
                            <li class="clearfix">
                                <i class="material-icons left notranslate">alarm_on</i>
                                Выезжаем в <b><?php  $time = new DateTime($nearest_convoy->departure_time); echo $time->format('H:i') ?></b> (по Москве)
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col l6 s12 flex-justify-center">
                    <div class="list-wrapper">
                        <ul class="fs17">
                            <li class="clearfix"><i class="material-icons left notranslate">headset_mic</i>Связь: <b><?=  $nearest_convoy->communications ?></b></li>
                            <li class="clearfix"><i class="material-icons left notranslate">dns</i>Сервер: <b><?= \app\models\Convoys::getSeverName($nearest_convoy->server) ?></b></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-action">
            <a href="<?=Url::to(['site/convoys', 'id' => $nearest_convoy->id])?>" class="indigo-text text-darken-3">Подробнее</a>
            <a href="<?=Yii::$app->request->baseUrl?>/images/convoys/<?= $nearest_convoy->picture_full ?>" target="_blank" class="indigo-text text-darken-3">Оригинал маршрута</a>
        </div>
    </div>
    <?php elseif(!$convoys) : ?>
        <div class="row">
            <div class="col s12">
                <div class="card grey lighten-4">
                    <div class="card-content">
                        <span class="card-title">Пока что нет конвоев =(</span>
                        <p>Следующий конвой уже готовится, и совсем скоро появится здесь.</p>
                        <?php if(!\app\models\User::isVtcMember()) : ?>
                            <p><a href="<?= Url::to(['site/recruit']) ?>">Вступай</a> в компанию, что бы видеть закрытые конвои!</p>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(count($convoys) > 1) : ?>
        <h5 class="light" style="margin-top: 50px;">Все конвои Volvo Trucks</h5>
        <div class="row">
            <?php foreach($convoys as $convoy) :
                $dt = new DateTime($convoy->departure_time);
                $time = $dt->format('H:i'); ?>
                <div class="col l6 s12">
                    <div class="card grey lighten-4 hoverable">
                        <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/convoys/<?= $convoy->picture_small ?>?t=<?= time() ?>)">
                            <a href="<?=Url::to(['site/convoys', 'id' => $convoy->id])?>" style="display: block;width: 100%;height: 100%;"></a>
                        </div>
                        <div class="card-content" style="min-height: 120px;">
                            <h6 class="light fs17"><a href="<?=Url::to(['site/convoys', 'id' => $convoy->id])?>" class="black-text"><?= $convoy->title ?></a></h6>
                            <span class="badge left green white-text" style="margin-left: 0;"><?= \app\controllers\SiteController::getRuDate($convoy->departure_time) ?> в <?= $time ?></span>

                        </div>
                        <div class="card-action">
                            <a href="<?= Url::to(['site/convoys', 'id' => $convoy->id]) ?>" class="indigo-text">Смотреть конвой</a>
                            <?php if(\app\models\User::isAdmin()): ?>
                                <a href="<?= Url::to(['site/convoys', 'id' => $convoy->id, 'action' => 'edit']) ?>" class="right indigo-text tooltipped" data-position="bottom" data-tooltip="Редактировать">
                                    <i class="material-icons notranslate">edit</i>
                                </a>
                                <a href="<?=Url::to(['site/convoys', 'id' => $convoy->id, 'action' => $convoy->visible == 1 ? 'hide' : 'show']) ?>" class="right indigo-text tooltipped" data-position="bottom" data-tooltip="Спрятать/Показать">
                                    <i class="material-icons notranslate"><?= $convoy->visible === 1 ? 'visibility' : 'visibility_off' ?></i>
                                </a>
                                <a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/convoys', 'id' => $convoy->id, 'action' => 'delete']) ?>" class="right indigo-text tooltipped" data-position="bottom" data-tooltip="Удалить">
                                    <i class="material-icons notranslate">delete</i>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
    <?php if(\app\models\User::isVtcMember() && count($hidden_convoys) > 0) : ?>
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">archive</i>Архив конвоев</div>
                <div class="collapsible-body grey lighten-4">
                    <ul class="force-list-style">
                        <?php foreach($hidden_convoys as $convoy) :
                            $dt = new DateTime($convoy->departure_time);
                            $time = $dt->format('H:i'); ?>
                            <li>
                                <a class="black-text light" href="<?= Url::to(['site/convoys', 'id' => $convoy->id]) ?>">
                                    <?= $convoy->title ?> - <?= \app\controllers\SiteController::getRuDate($convoy->departure_time) ?> в <?= $time ?>
                                </a>
                                <?php if(\app\models\User::isAdmin()) : ?>
                                    <i class="material-icons notranslate tiny grey-text" style="vertical-align: text-top;"><?= $convoy->visible === 1 ? 'visibility' : 'visibility_off' ?></i>
                                <?php endif ?>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </li>
        </ul>
    <?php endif ?>
    <?php if(\app\models\User::isAdmin()) : ?>
        <div class="fixed-action-btn">
            <a href="<?=Url::to(['site/convoys', 'action' => 'add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons notranslate">add</i></a>
        </div>
    <?php endif; ?>
</div>