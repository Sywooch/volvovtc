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
                        <p>Следущий конвой уже готовится, и совсем скоро появится здесь.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(count($convoys) > 1 || $hidden_convoys) : ?>
    <div class="card grey lighten-4">
        <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/assets/img/convoys.jpg)">
            <span class="card-title text-shadow">Все конвои Volvo Trucks</span>
        </div>
        <div class="card-content">
            <?php foreach($convoys as $convoy) :
                $dt = new DateTime($convoy->departure_time);
                $time = $dt->format('H:i'); ?>
                <div class="convoy row flex">
                    <div class="convoy-title">
                        <span class="badge left green white-text"><?= \app\controllers\SiteController::getRuDate($convoy->departure_time) ?> в <?= $time ?></span>
                        <a href="<?=Url::to(['site/convoys', 'id' => $convoy->id])?>" class="black-text"><?= $convoy->title ?></a>
                    </div>
                    <div class="no-padding" style="line-height: 50px;">
                        <a href="<?=Url::to(['site/convoys',
                            'id' => $convoy->id])?>" class="btn indigo darken-3 waves-effect waves-light">
                            <i class="material-icons right">send</i>Смотреть конвой
                        </a>
                        <?php if(\app\models\User::isAdmin()) : ?>
							<div class="convoys-actions flex">
								<a href="<?=Url::to(['site/convoys',
									'id' => $convoy->id,
									'action' => 'edit'])?>" class="indigo-text waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Редактировать">
									<i class="material-icons">edit</i>
								</a>
								<a href="<?=Url::to(['site/convoys',
									'id' => $convoy->id,
									'action' => $convoy->visible == 1 ? 'hide' : 'show'])
								?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Спрятать/Показать">
									<i class="material-icons"><?= $convoy->visible === 1 ? 'visibility' : 'visibility_off' ?></i>
								</a>
								<a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/convoys',
									'id' => $convoy->id,
									'action' => 'delete'])
								?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Удалить">
									<i class="material-icons">delete</i>
								</a>
							</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach;
            if(\app\models\User::isAdmin()) :
            foreach($hidden_convoys as $convoy) :
                $dt = new DateTime($convoy->departure_time);
                $time = $dt->format('H:i'); ?>
                <div class="convoy row flex gray">
                    <div class="convoy-title">
                        <span class="badge left yellow black-text"><?= \app\controllers\SiteController::getRuDate($convoy->departure_time) ?> в <?= $time ?></span>
                        <a href="<?=Url::to(['site/convoys', 'id' => $convoy->id])?>" class="black-text"><?= $convoy->title ?></a>
                    </div>
                    <div class="no-padding" style="line-height: 50px;">
                        <a href="<?=Url::to(['site/convoys',
                            'id' => $convoy->id])?>" class="btn indigo darken-3 waves-effect waves-light">
                            <i class="material-icons right">send</i>Смотреть конвой
                        </a>
                        <?php if(\app\models\User::isAdmin()) : ?>
							<div class="convoys-actions flex">
								<a href="<?=Url::to(['site/convoys',
									'id' => $convoy->id,
									'action' => 'edit'])?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Редактировать">
									<i class="material-icons">edit</i>
								</a>
								<a href="<?=Url::to(['site/convoys',
									'id' => $convoy->id,
									'action' => $convoy->visible == 1 ? 'hide' : 'show'])
								?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Спрятать/Показать">
									<i class="material-icons"><?= $convoy->visible === 1 ? 'visibility' : 'visibility_off' ?></i>
								</a>
								<a onclick='return confirm("Удалить?")' href="<?=Url::to(['site/convoys',
									'id' => $convoy->id,
									'action' => 'delete'])
								?>" class="indigo-text tooltipped" data-position="bottom" data-tooltip="Удалить">
									<i class="material-icons">delete</i>
								</a>
							</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach;
            endif; ?>
            </ul>
        </div>
    </div>
    <?php endif;
    if(\app\models\User::isAdmin()) : ?>
        <div class="fixed-action-btn">
            <a href="<?=Url::to(['site/convoys', 'action' => 'add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>
        </div>
    <?php endif; ?>
</div>