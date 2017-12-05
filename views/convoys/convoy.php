<?php

use app\models\Convoys;
use yii\helpers\Url;

$this->title = $convoy->title .' от '. $convoy->date . ' - Volvo Trucks';
?>

<div class="container">
    <div class="card grey lighten-4">
        <div class="card-image convoy-map">
			<?php if($convoy->picture_full): ?>
				<img src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?= $convoy->picture_small ?>?t=<?= time() ?>" class="materialboxed">
			<?php else: ?>
				<img src="<?=Yii::$app->request->baseUrl?>/assets/img/no_route.jpg">
			<?php endif ?>
            <span class="card-title text-shadow"><?=  $convoy->title ?></span>
        </div>
        <div class="card-content">
            <p><?=  $convoy->description ?></p>
            <?php if($dlc = unserialize($convoy->dlc)) : ?>
                <p class="grey-text">
                    <?= \app\models\Convoys::getDLCString(unserialize($convoy->dlc)) ?>
                </p>
            <?php endif ?>
            <div class="row flex-justify-center convoy-cities">
                <div class="start-place">
                    <div class="left-wrapper right">
                        <h6>Старт:</h6>
                        <h4 class="convoy-city nowrap"><?=  $convoy->start_city ?></h4>
                        <h6 class="convoy-company nowrap"><?=  $convoy->start_company ?></h6>
                    </div>
                </div>
                <div class="center-align arrow">
                    <i class="material-icons medium notranslate">arrow_forward</i>
                </div>
                <div class="finish-place">
                    <div class="right-wrapper left">
                        <h6>Финиш:</h6>
                        <h4 class="convoy-city nowrap"><?=  $convoy->finish_city ?></h4>
                        <h6 class="convoy-company nowrap"><?=  $convoy->finish_company ?></h6>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col l6 s12 flex-justify-center">
                    <div class="list-wrapper">
                        <ul class="fs17">
                            <li class="clearfix"><i class="material-icons left notranslate">event</i>Дата: <b><?=  $convoy->date ?></b></li>
                            <li class="clearfix">
                                <i class="material-icons left notranslate">access_time</i>
                                Сборы в <b><?php  $time = new DateTime($convoy->meeting_time); echo $time->format('H:i') ?></b> (по Москве)
                            </li>
                            <li class="clearfix">
                                <i class="material-icons left notranslate">alarm_on</i>
                                Выезжаем в <b><?php  $time = new DateTime($convoy->departure_time); echo $time->format('H:i') ?></b> (по Москве)
                            </li>
                            <li class="clearfix"><i class="material-icons left notranslate">headset_mic</i>Связь: <b><?=  $convoy->communications ?></b></li>
                        </ul>
                    </div>

                </div>
                <div class="col l6 s12 flex-justify-center">
                    <div class="list-wrapper">
                        <ul class="fs17">
                            <li class="clearfix"><i class="material-icons left notranslate">hotel</i>Отдых: <b><?=  $convoy->rest ?></b></li>
                            <li class="clearfix"><i class="material-icons left notranslate">dns</i>Сервер: <b><?=  $convoy->server ?></b></li>
                            <li class="clearfix"><i class="material-icons left notranslate">swap_calls</i>Протяженность: <b><?=  $convoy->length ?></b></li>
                            <li class="clearfix"><i class="material-icons left notranslate">volume_up</i>
                                Игровая рация:
                                <?php if($convoy->open): ?><b>15 канал</b>
                                <?php else: ?><b>17 канал</b>
                                <?php endif ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php $datetime1 = new DateTime($convoy->departure_time);
                $datetime2 = new DateTime('now');
                $interval = $datetime1->diff($datetime2); ?>
                <?php if(!($interval->format('%h') >= '2' || $interval->format('%a') > '0') || $interval->format('%R') == '-') : ?>
                    <div class="clearfix convoy-participants">
                        <h5 class="light center">Подтвердили участие:
                            <?php  ?>
                            <?php if(is_array($participants) && key_exists('100',$participants) && count($participants['100']) > 0) : ?>
                                <a href="#modal" class="modal-trigger participants-count"><?= count($participants['100']) ?></a>
                            <?php else: ?>
                                <span class="participants-count">0</span>
                            <?php endif ?>
                        </h5>
                        <?php if(!is_array($participants)) $convoy->participants = ['100' => [], '50' => [], '0' => []];
                        if(!Yii::$app->user->isGuest) : ?>
                            <div class="flex-justify-center participate-btns" data-uid="<?= Yii::$app->user->id ?>" data-cid="<?= Yii::$app->request->get('id') ?>">
                                <button class="btn green darken-3<?php if(in_array(Yii::$app->user->id, $convoy->participants['100'])) echo ' disabled' ?>" data-participate="100">
                                    Точно поеду
                                </button>
                                <button class="btn yellow darken-4<?php if(in_array(Yii::$app->user->id, $convoy->participants['50'])) echo ' disabled' ?>" data-participate="50">
                                    Возможно поеду
                                </button>
                                <button class="btn red darken-3<?php if(in_array(Yii::$app->user->id, $convoy->participants['0'])) echo ' disabled' ?>" data-participate="0">
                                    Не поеду
                                </button>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
            <?php if($convoy->author) : ?>
                <h6 class="grey-text">Конвой сделал: <?= $convoy->author ?></h6>
            <?php endif ?>
            <?php if($convoy->updated && \app\models\User::isAdmin()) :
                $date = new \DateTime($convoy->updated); ?>
                <h6 class="grey-text">
                    Последнее обновление:
                    <?php if($convoy->updated_by) :
                        $user = \app\models\User::findOne($convoy->updated_by) ?>
                        <?= $user->first_name . ' ' . $user->last_name ?> -
                    <?php endif ?>
                    <?= \app\controllers\SiteController::getRuDate($convoy->updated) ?> в <?= $date->format('H:i') ?>
                </h6>
            <?php endif ?>
        </div>
        <div class="card-action">
            <a href="<?=Yii::$app->request->baseUrl?>/images/convoys/<?=  $convoy->picture_full ?>" target="_blank" class="indigo-text text-darken-3">Оригинал маршрута</a>
            <?php if(\app\models\User::isAdmin() && $convoy->scores_set == '0') : ?>
                <a href="<?= Url::to(['convoys/scores', 'id' => $convoy->id]) ?>">Выставить баллы за конвой</a>
            <?php endif ?>
        </div>
    </div>
    <?php if($convoy->open) : ?>
        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header grey lighten-4">
                    <i class="material-icons notranslate">add_circle</i>Дополнительная информация для сотрудников ВТК Volvo Trucks
                </div>
                <div class="collapsible-body grey lighten-4">
                    <div class="row">
                        <div class="col m6 s12">
                            <h5 class="card-title light">
                                Вариаци<?= $convoy->truck_var == 2 || $convoy->truck_var == 4 || $convoy->truck_var == 5 ? 'и' : 'я' ?> на конвой:
                            </h5>
                            <?= Convoys::getVarList(explode(',', $convoy->truck_var)[0], explode(',', $convoy->truck_var)[1] == '1') ?>
                            <?php if($convoy->add_info) : ?>
                                <p><?= $convoy->add_info ?></p>
                            <?php endif ?>
                            <?php if($convoy->extra_picture) : ?>
                                <img class="materialboxed z-depth-2" src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?=  $convoy->extra_picture ?>?t=<?= time() ?>" width="100%">
                            <?php endif ?>
                        </div>
                        <div class="col m6 s12">
                            <h5 class="card-title light">
                                Прицеп<?php if(count($convoy->trailer)):?>ы<?php endif ?> на конвой:
                            </h5>
                            <?= \app\models\Trailers::getTrailersListHtml($convoy->trailer) ?>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    <?php else: ?>
        <div class="card grey lighten-4">
            <div class="card-content">
                <div class="row">
                    <div class="col m6 s12">
                        <h5 class="card-title light">
                            Вариаци<?= $convoy->truck_var == 2 || $convoy->truck_var == 4 || $convoy->truck_var == 5 ? 'и' : 'я' ?> на конвой:
                        </h5>
                        <?php if($convoy->game == 'ats') : ?>
                            <?= str_replace('Любая вариация', 'Любой тягач', Convoys::getVarList(explode(',', $convoy->truck_var)[0], explode(',', $convoy->truck_var)[1] == '1')) ?>
                        <?php else : ?>
                            <?= Convoys::getVarList(explode(',', $convoy->truck_var)[0], explode(',', $convoy->truck_var)[1] == '1') ?>
                        <?php endif ?>
                        <?php if($convoy->add_info) : ?>
                            <p><?= $convoy->add_info ?></p>
                        <?php endif ?>
                        <?php if($convoy->extra_picture) : ?>
                            <img class="materialboxed z-depth-2" src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?=  $convoy->extra_picture ?>?t=<?= time() ?>" width="100%" ">
                        <?php endif ?>
                    </div>
                    <div class="col m6 s12">
                        <h5 class="card-title light">
                            Прицеп<?php if(count($convoy->trailer)):?>ы<?php endif ?> на конвой:
                        </h5>
                        <?= \app\models\Trailers::getTrailersListHtml($convoy->trailer) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
    <?php if(is_array($participants) && key_exists('100',$participants) && count($participants['100']) > 0) : ?>
        <div id="modal" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>Подтвердили участие в конвое:</h4>
                <ul class="participants-list collection">
                    <?php foreach($participants['100'] as $participant) : ?>
                        <li class="participant-item collection-item avatar">
                            <a href="<?= Url::to(['site/profile', 'id' => $participant->id]) ?>">
                                <img src="<?= Yii::$app->request->baseUrl ?>/images/users/<?= $participant->picture ?>" class="circle">
                            </a>
                            <span style="font-size: 1.64rem" class="light">
                                <?php if($participant->company) : ?>
                                    [<?= $participant->company ?>]
                                <?php endif ?>
                                <?= $participant->nickname ?>
                            </span>
                        </li>
                    <?php endforeach ?>
                </ul>
                <?php if(key_exists('50', $participants)): ?>
                <h4>Возможно поедут:</h4>
                <ul class="participants-list collection">
                        <?php foreach($participants['50'] as $participant) : ?>
                            <li class="participant-item collection-item avatar">
                                <a href="<?= Url::to(['site/profile', 'id' => $participant->id]) ?>">
                                    <img src="<?= Yii::$app->request->baseUrl ?>/images/users/<?= $participant->picture ?>" class="circle">
                                </a>
                                <span style="font-size: 1.64rem" class="light">
                                    <?php if($participant->company) : ?>
                                        [<?= $participant->company ?>]
                                    <?php endif ?>
                                    <?= $participant->nickname ?>
                                </span>
                            </li>
                        <?php endforeach ;
                    endif ?>
                </ul>
                <?php if(key_exists('0', $participants)): ?>
                <h4>Отказались от участия:</h4>
                <ul class="participants-list collection">
                        <?php foreach($participants['0'] as $participant) : ?>
                            <li class="participant-item collection-item avatar grey lighten-4">
                                <a href="<?= Url::to(['site/profile', 'id' => $participant->id]) ?>">
                                    <img src="<?= Yii::$app->request->baseUrl ?>/images/users/<?= $participant->picture ?>" class="circle">
                                </a>
                                <span style="font-size: 1.64rem" class="light">
                                    <?php if($participant->company) : ?>
                                        [<?= $participant->company ?>]
                                    <?php endif ?>
                                    <?= $participant->nickname ?>
                                </span>
                            </li>
                        <?php endforeach;
                    endif ?>
                </ul>
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect waves-green btn-flat ">Закрыть</a>
            </div>
        </div>
    <?php endif ?>
    <?php if(\app\models\User::isAdmin()) : ?>
        <div class="fixed-action-btn vertical">
            <a href="<?=Url::to([
                'convoys/edit',
                'id' => $convoy->id
            ])?>" class="btn-floating btn-large red tooltipped" data-position="left" data-tooltip="Редактировать">
                <i class="large material-icons notranslate">mode_edit</i>
            </a>
            <ul>
                <li>
                    <a onclick='return confirm("Удалить?")' href="<?=Url::to([
                        'convoys/remove',
                        'id' => $convoy->id
                    ])?>" class="btn-floating yellow darken-3 tooltipped" data-position="left" data-tooltip="Удалить">
                        <i class="material-icons notranslate">delete</i>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::to([
                        $convoy->visible == '1' ? 'convoys/hide' : 'convoys/show',
                        'id' => $convoy->id
                    ])?>" class="btn-floating green tooltipped" data-position="left" data-tooltip="<?= $convoy->visible == '1' ?
                        'Скрыть конвой' : 'Сделать видимым' ?>">
                        <i class="material-icons notranslate"><?= $convoy->visible == '1' ? 'visibility_off' : 'visibility' ?></i>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</div>