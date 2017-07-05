<?php

use yii\helpers\Url;

$this->title = 'Конвои Volvo Trucks';
?>

<div class="container">
    <?php if($nearest_convoy) : ?>
    <div class="card grey lighten-4">
        <div class="card-image convoy-map">
			<?php if($nearest_convoy->picture_full): ?>
				<img src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?= $nearest_convoy->picture_small ?>?t=<?= time() ?>" class="materialboxed">
			<?php else: ?>
				<img src="<?=Yii::$app->request->baseUrl?>/assets/img/no_route.jpg">
			<?php endif ?>
            <span class="card-title text-shadow">Ближайший конвой</span>
        </div>
        <div class="card-content">
            <h5><?= $nearest_convoy->title ?><span class="badge green white-text"><?= \app\controllers\SiteController::getRuDate($nearest_convoy->departure_time) ?></span></h5>

            <span><?= $nearest_convoy->description ?></span>
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
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(count($convoys) > 1 || $hidden_convoys) : ?>
        <h5 class="light" style="margin-top: 50px;">Все конвои Volvo Trucks</h5>
        <div class="row">
            <?php foreach($convoys as $convoy) :
                $dt = new DateTime($convoy->departure_time);
                $time = $dt->format('H:i'); ?>
                <div class="col l6 s12">
                    <div class="card grey lighten-4 ">
                        <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/convoys/<?= $convoy->picture_small ?>)">
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
                                    <i class="material-icons">edit</i>
                                </a>
                                <a href="<?=Url::to(['site/convoys', 'id' => $convoy->id, 'action' => $convoy->visible == 1 ? 'hide' : 'show']) ?>" class="right indigo-text tooltipped" data-position="bottom" data-tooltip="Спрятать/Показать">
                                    <i class="material-icons"><?= $convoy->visible === 1 ? 'visibility' : 'visibility_off' ?></i>
                                </a>
                                <a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/convoys', 'id' => $convoy->id, 'action' => 'delete']) ?>" class="right indigo-text tooltipped" data-position="bottom" data-tooltip="Удалить">
                                    <i class="material-icons">delete</i>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <ul class="collapsible" data-collapsible="accordion">
            <li>
                <div class="collapsible-header"><i class="material-icons">archive</i>Архив конвоев</div>
                <div class="collapsible-body">
                    <ul class="force-list-style">
                        <?php foreach($hidden_convoys as $convoy) : ?>
                            <li>
                                <a class="black-text light" href="<?= Url::to(['site/convoys', 'id' => $convoy->id]) ?>">
                                    <?= $convoy->title ?> - <?= \app\controllers\SiteController::getRuDate($convoy->departure_time) ?> в <?= $time ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </li>
        </ul>
    <?php endif;
    if(\app\models\User::isAdmin()) : ?>
        <div class="fixed-action-btn">
            <a href="<?=Url::to(['site/convoys', 'action' => 'add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
        </div>
    <?php endif; ?>
</div>