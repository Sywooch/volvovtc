<?php

use yii\helpers\Url;

$this->title = $convoy->title .' от '. $convoy->date . ' - Volvo Trucks';
//$this->registerJsFile('https://vk.com/js/api/share.js?94', ['position' => yii\web\View::POS_HEAD]);
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
            <div class="row">
                <div class="col l6 s12">
                    <ul class="browser-default">
                        <li>Дата: <b><?=  $convoy->date ?></b></li>
                        <li>Сборы в <b><?php  $time = new DateTime($convoy->meeting_time); echo $time->format('H:i') ?></b> (по Москве)</li>
                        <li>Выезжаем в <b><?php  $time = new DateTime($convoy->departure_time); echo $time->format('H:i') ?></b> (по Москве)</li>
                        <li>Связь: <b><?=  $convoy->communications ?></b></li>
                        <li>Игровая рация:
                            <?php if($convoy->open): ?><b>15 канал</b>
                            <?php else: ?><b>17 канал</b>
                            <?php endif ?>
                        </li>
                    </ul>
                </div>
                <div class="col l6 s12">
                    <ul class="browser-default">
                        <li>Начальная точка: <b><?=  $convoy->start_city ?> (<?=  $convoy->start_company ?>)</b></li>
                        <li>Отдых: <b><?=  $convoy->rest ?></b></li>
                        <li>Конечная точка: <b><?=  $convoy->finish_city ?> (<?=  $convoy->finish_company ?>)</b></li>
                        <li>Сервер <b><?=  $convoy->server ?></b></li>
                        <li>Протяженность: <b><?=  $convoy->length ?></b></li>
                    </ul>
                </div>
            </div>

            <?php $trailer_name = 'Любой прицеп';
            if($convoy->trailer):
                if($convoy->trailer == '-1') {
                    $trailer_name = 'Без прицепа';
                }else{
                    $trailer = \app\models\Trailers::findOne($convoy->trailer);
                    $trailer_image = $trailer->picture;
                    $trailer_name = $trailer->name;
                } ?>
            <?php endif ?>
            <?php if($convoy->open) : ?>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4">
                            <i class="material-icons">add_circle</i>Дополнительная информация для сотрудников ВТК Volvo Trucks
                        </div>
                        <div class="collapsible-body grey lighten-4">
                            <ul class="force-list-style" style="margin: 0 0 20px 0">
                                <li><b><?=  $convoy->truck_var ?></b></li>
                                <li>Прицеп: <b><?= $trailer_name ?></b>
                                    <?php if($mod) : ?> -
                                        <a target="_blank" href="<?= Yii::$app->request->baseUrl.'/mods/'.$mod->game.'/'.$mod->file_name?>" class="indigo-text">
                                            Загрузить модификацию
                                        </a>
                                    <?php endif ?></li>
                            </ul>
                            <?php if(isset($trailer_image)) : ?>
                                <img class="materialboxed z-depth-2" src="<?=Yii::$app->request->baseUrl?>/images/trailers/<?=  $trailer_image ?>?t=<?= time() ?>" width="100%" alt="<?=  $trailer_name ?>">
                            <?php endif; ?>
                            <?php if($convoy->extra_picture) : ?>
                                <img class="materialboxed z-depth-2" src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?=  $convoy->extra_picture ?>?t=<?= time() ?>" width="100%" ">
                            <?php endif ?>
                        </div>
                    </li>
                </ul>
            <?php else : ?>
                <h5 class="light">Дополнительная информация</h5>
                <ul class="force-list-style" style="margin: 0 0 20px 30px">
                    <li><b><?=  $convoy->truck_var ?></b></li>
                    <li>Прицеп: <b><?= $trailer_name ?></b>
                        <?php if($mod) : ?> -
                            <a target="_blank" href="<?= Yii::$app->request->baseUrl.'/mods/'.$mod->game.'/'.$mod->file_name?>" class="indigo-text">
                                Загрузить модификацию
                            </a>
                        <?php endif ?></li>
                </ul>
                <?php if($convoy->add_info) : ?>
                    <p><?= $convoy->add_info ?></p>
                <?php endif ?>
                <?php if(isset($trailer_image)) : ?>
                    <img class="materialboxed" src="<?=Yii::$app->request->baseUrl?>/images/trailers/<?=  $trailer_image ?>?t=<?= time() ?>" width="100%" alt="<?=  $trailer_name ?>">
                <?php endif; ?>
                <?php if($convoy->extra_picture) : ?>
                    <img class="materialboxed z-depth-2" src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?=  $convoy->extra_picture ?>?t=<?= time() ?>" width="100%" ">
                <?php endif ?>
            <?php endif ?>
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
        </div>
        <?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->admin == 1) : ?>
            <div class="fixed-action-btn vertical">
                <a href="<?=Url::to([
                    'site/convoys',
                    'id' => $convoy->id,
                    'action' => 'edit'
                ])?>" class="btn-floating btn-large red tooltipped" data-position="left" data-tooltip="Редактировать">
                    <i class="large material-icons">mode_edit</i>
                </a>
                <ul>
                    <li>
                        <a onclick='return confirm("Удалить?")' href="<?=Url::to([
                            'site/convoys',
                            'id' => $convoy->id,
                            'action' => 'delete'
                        ])?>" class="btn-floating yellow darken-3 tooltipped" data-position="left" data-tooltip="Удалить">
                            <i class="material-icons">delete</i>
                        </a>
                    </li>
                    <li>
                        <a href="<?=Url::to([
                            'site/convoys',
                            'id' => $convoy->id,
                            'action' => $convoy->visible == '1' ? 'hide' : 'show'
                        ])?>" class="btn-floating green tooltipped" data-position="left" data-tooltip="<?= $convoy->visible == '1' ?
                            'Скрыть конвой' : 'Сделать видимым' ?>">
                            <i class="material-icons"><?= $convoy->visible == '1' ? 'visibility_off' : 'visibility' ?></i>
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>