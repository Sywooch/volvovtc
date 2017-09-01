<?php

use yii\helpers\Url;

$this->title = 'Достижения - Volvo Trucks';
?>

<div class="parallax-container parallax-shadow" style="height: 300px;">
    <div class="container">
        <h4 class="parallax-title light white-text text-shadow">Достижения</h4>
    </div>
    <div class="parallax"><img src="<?=Yii::$app->request->baseUrl?>/assets/img/achievements.jpg"></div>
</div>
<div class="container">
    <div class="row">
        <?php if(count($achievements) > 0) {
            foreach ($achievements as $key => $achievement):
                $progress_percent = 0;
                $card_color = 'grey lighten-4';
                $completed = false;
                if($user_complete_ach && in_array($achievement->id, $user_complete_ach)){
                    $card_color = 'green lighten-2';
                    $completed = true;
                }
                $progress = 0;
                if(!$completed){
                    foreach ($user_ach_progress as $ach){
                        if($achievement->id == $ach['ach_id']) $progress++;
                    }
                    if($progress > 0) $progress_percent = $progress / $achievement->progress * 100;
                }
                if($key % 3 == 0) : ?>
                    <div class="clearfix"></div>
                <?php endif ?>
                <div class="col s12 m4">
                    <div class="card <?= $card_color ?> hoverable">
                        <div class="card-image">
                            <?php if($progress_percent > 0) : ?>
                                <div class="progress" style="margin: 0;">
                                    <div class="determinate" style="width: <?= $progress_percent ?>%"></div>
                                </div>
                            <?php endif;?>
                            <?php if($completed): ?>
                                <div class="complete-achievement flex">
                                    <i class="material-icons notranslate green-text large text-shadow">check</i>
                                </div>
                            <?php endif ?>
                            <img src="images/achievements/<?= $achievement->image ? $achievement->image : 'default.jpg' ?>">
                            <div class="card-title text-shadow"><?= $achievement->title ?></div>
                        </div>
                        <div class="card-content">
                            <p><?= $achievement->description ?></p>
                        </div>
                        <div class="card-action" style="position: relative; min-height: 55px;">
                            <?php if(!$completed) : ?>
                                <a href="#modal1" class="modal-trigger get-achievement" data-id="<?= $achievement->id ?>" data-title="<?= $achievement->title ?>">Выполнить</a>
                            <?php endif ?>
                            <?php if(\app\models\User::isAdmin()) : ?>
                                <a class='achievement-action-dropdown-button right' data-id="<?= $achievement->id ?>"><i class="material-icons notranslate">more_vert</i></a>
                                <ul id="achievement-dropdown-<?= $achievement->id ?>" class='achievement-dropdown card-panel grey lighten-4'>
                                    <li class="clearfix">
                                        <a href="<?= Url::to(['achievements/edit', 'id' => $achievement->id]) ?>" class="indigo-text">
                                            <i class="material-icons notranslate left">edit</i>Редактировать
                                        </a>
                                    </li>
                                    <li class="clearfix">
                                        <a onclick='return confirm("Удалить?")' href="<?= Url::to(['achievements/remove', 'id' => $achievement->id]) ?>" class="indigo-text">
                                            <i class="material-icons notranslate left">delete</i>Удалить
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="clearfix">
                                        <a href="<?= Url::to(['achievements/sort', 'id' => $achievement->id, 'operation' => 'up']) ?>" class="indigo-text">
                                            <i class="material-icons notranslate left">keyboard_arrow_up</i>Переместить выше
                                        </a>
                                    </li>
                                    <li class="clearfix">
                                        <a href="<?= Url::to(['achievements/sort', 'id' => $achievement->id, 'operation' => 'down']) ?>" class="indigo-text">
                                            <i class="material-icons notranslate left">keyboard_arrow_down</i>Переместить ниже
                                        </a>
                                    </li>
                                </ul>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div id="modal1" class="modal">
                <div class="modal-content container">
                    <h5 class="light">Выполнение достижения "<span class="ach-modal-title"></span>"</h5>
                    <div class="file-field input-field">
                        <div class="btn indigo darken-3">
                            <span>Загрузить скриншот</span>
                            <input type="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="modal-action waves-effect btn-flat" id="get-ach" data-uid="<?= Yii::$app->user->id ?>" data-achid="0">Выполнить</a>
                    <a class="modal-action modal-close waves-effect btn-flat">Закрыть</a>
                </div>
            </div>
        <?php }else{ ?>
            <h5 class="light">Нету достижений</h5>
        <?php } ?>
    </div>
    <?php if(\app\models\User::isAdmin()): ?>
        <div class="fixed-action-btn tooltipped" data-position="left" data-tooltip="Новое достижение">
            <a href="<?=Url::to(['achievements/add'])?>" class="btn-floating btn-large waves-effect waves-light red"><i class="material-icons notranslate">add</i></a>
        </div>
        <div class="fixed-action-btn tooltipped" style="margin-bottom: 71px" data-position="left" data-tooltip="Модерация достижений">
            <a href="<?=Url::to(['achievements/moderate'])?>" class="btn-floating btn-large waves-effect waves-light green"><i class="material-icons notranslate">check_circle</i></a>
        </div>
    <?php endif ?>
</div>