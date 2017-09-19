<?php

use yii\helpers\Url;

$this->title = 'Водители Volvo Trucks';

?>
    <div class="members-stat" style="overflow-x: scroll">
        <table class="centered highlight bordered">
            <thead>
            <tr class="grey darken-2 white-text">
                <th class="first"></th>
                <th>Никнейм</th>
                <th>Имя Фамилия</th>
                <th>Профили</th>
                <th>Должность</th>
                <th colspan="3">Возможности</th>
                <th colspan="3">Баллы</th>
                <?php if(\app\models\User::isAdmin()) : ?>
                    <th></th>
                <?php endif ?>
                <th colspan="2">Экзамены</th>
                <th>Возраст</th>
            </tr>
            </thead>

            <?php $i = 1;
            foreach($all_members as $post => $members): ?>
                <thead>
                <tr class="grey lighten-1">
                    <th></th>
                    <th><?= $post ?></th>
                    <th colspan="3"></th>
                    <th>В</th>
                    <th>Ц</th>
                    <th>З</th>
                    <th>Другое</th>
                    <th>Месяц</th>
                    <th>Всего</th>
                    <?php if(\app\models\User::isAdmin()) : ?>
                        <th></th>
                    <?php endif ?>
                    <th>Парковка</th>
                    <th>Вождение</th>
                    <th></th>
                </tr>
                </thead>
                <?php foreach($members as $member) : ?>
                    <tr class="<?php if($member->vacation != '' || $member->vacation_undefined == '1') : ?>yellow lighten-4<?php endif ?><?php if($member->banned): ?>red lighten-4<?php endif ?>" data-uid="<?= $member->user_id->id ?>">
                        <td><?= $i++ ?></td>
                        <td style="text-align: left; padding-left: 20px;white-space: nowrap;">
                            <a class="member-img circle z-depth-3 waves-effect waves-light <?php if(\app\models\User::isOnline($member->user_id)) : ?>online<?php endif ?>" href="<?= Url::to(['site/profile', 'id' => $member->user_id->id]) ?>" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?= $member->user_id->picture ?>)"></a>
                            <div style="display: inline-block; vertical-align: middle;">
                                <a href="<?= \app\models\User::isAdmin() ? Url::to(['members/edit', 'id' => $member->id]) : Url::to(['site/profile', 'id' => $member->user_id->id]) ?>" class="black-text">[Volvo Trucks] <?= $member->user_id->nickname ?></a>
                                <?php if($member->vacation != '' || $member->vacation_undefined == '1') : ?>
                                    <span class="member-vacation grey-text" style="display: block;">В отпуске <?= $member->vacation_undefined == '1' ? 'на н. срок' : 'до ' . \app\controllers\SiteController::getRuDate($member->vacation) ?></span>
                                <?php endif ?>
                            </div>

                        </td>
                        <td><?= $member->user_id->first_name . ' ' . $member->user_id->last_name ?></td>
                        <td>
                            <ul class="user-links" style="width: 84px;">
                                <?php if($member->user_id->vk) : ?>
                                    <li class="vk"><a class="waves-effect circle" target="_blank" href="<?= $member->user_id->vk ?>"></a></li>
                                <?php endif; ?>
                                <?php if($member->user_id->steam) : ?>
                                    <li class="steam<?php if(!\app\models\User::isAdmin() && $member->user_id->visible_steam != 1):?> link-disabled<?php endif ?>">
                                        <a class="waves-effect circle" <?php if(\app\models\User::isAdmin() || $member->user_id->visible_steam == 1):?> href="<?= $member->user_id->steam ?>"<?php endif ?> target="_blank"></a>
                                    </li>
                                <?php endif; ?>
                                <?php if($member->user_id->truckersmp) : ?>
                                    <li class="truckers-mp<?php if(!\app\models\User::isAdmin() && $member->user_id->visible_truckersmp != 1):?> link-disabled<?php endif ?>">
                                        <a class="waves-effect circle" <?php if(\app\models\User::isAdmin() || $member->user_id->visible_truckersmp == 1):?> href="<?= $member->user_id->truckersmp ?>"<?php endif ?> target="_blank"></a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </td>
                        <td><b><?= $member->post_id->name ?></b></td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <i class="material-icons notranslate <?= $member->can_lead == '1' ? 'green' : 'black' ?>-text" style="vertical-align: bottom;">
                                    <?= $member->can_lead == '1' ? 'check_box' : 'check_box_outline_blank' ?>
                                </i>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <i class="material-icons notranslate <?= $member->can_center == '1' ? 'green' : 'black' ?>-text" style="vertical-align: bottom;">
                                    <?= $member->can_center == '1' ? 'check_box' : 'check_box_outline_blank' ?>
                                </i>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <i class="material-icons notranslate <?= $member->can_close == '1' ? 'green' : 'black' ?>-text" style="vertical-align: bottom;">
                                    <?= $member->can_close == '1' ? 'check_box' : 'check_box_outline_blank' ?>
                                </i>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <span<?php if(\app\models\User::isAdmin()) : ?> data-scores-other-id="<?= $member->id ?>"<?php endif ?>>
                                <?= $member->scores_other == '0' ? '' : $member->scores_other ?>
                            </span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <span<?php if(\app\models\User::isAdmin()) : ?> data-scores-month-id="<?= $member->id ?>"<?php endif ?>>
                                <?= $member->scores_month == '0' ? '' : $member->scores_month ?>
                            </span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <span<?php if(\app\models\User::isAdmin()) : ?> data-scores-total-id="<?= $member->id ?>"<?php endif ?>>
                                <b><?= $member->scores_total == '0' ? '' : $member->scores_total ?></b>
                            </span>
                            <?php endif ?>
                        </td>
                        <?php if(\app\models\User::isAdmin()) : ?>
                            <?php $scores_updated = null;
                            if($member->scores_updated){
                                $scores_date = new DateTime($member->scores_updated);
                                $scores_updated = $scores_date->format('d.m.y H:i');
                            } ?>
                            <td<?php if(\app\models\User::isAdmin() && $scores_updated): ?> class="tooltipped" data-tooltip="Обновлено: <?= $scores_updated ?>"<?php endif ?>>
                                <a href="<?= $member->post_id->admin == 1 ? Url::to(['members/edit', 'id' => $member->id]) : '#modal1' ?>" data-id="<?= $member->id ?>" data-scores-other="<?= $member->scores_other ?>" data-scores-month="<?= $member->scores_month ?>" data-scores-total="<?= $member->scores_total ?>" data-nickname="<?= $member->user_id->nickname ?>" data-profile-link="<?= Url::to(['site/profile', 'id' => $member->user_id->id]) ?>" data-edit-profile-link="<?= Url::to(['members/edit', 'id' => $member->id]) ?>" class="indigo-text iconed modal-trigger notranslate">edit</a>
                            </td>
                        <?php endif ?>
                        <td style="min-width: 90px">
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <i class="material-icons notranslate <?= $member->exam_3_cat == '1' ? 'green' : 'black' ?>-text" style="vertical-align: bottom;">
                                    <?= $member->exam_3_cat == '1' ? 'check_box' : 'check_box_outline_blank' ?>
                                </i>
                                <i class="material-icons notranslate <?= $member->exam_2_cat == '1' ? 'green' : 'black' ?>-text" style="vertical-align: bottom;">
                                    <?= $member->exam_2_cat == '1' ? 'check_box' : 'check_box_outline_blank' ?>
                                </i>
                                <i class="material-icons notranslate <?= $member->exam_1_cat == '1' ? 'green' : 'black' ?>-text" style="vertical-align: bottom;">
                                    <?= $member->exam_1_cat == '1' ? 'check_box' : 'check_box_outline_blank' ?>
                                </i>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <i class="material-icons notranslate <?= $member->exam_driving == '1' ? 'green' : 'black' ?>-text" style="vertical-align: bottom;">
                                    <?= $member->exam_driving == '1' ? 'check_box' : 'check_box_outline_blank' ?>
                                </i>
                            <?php endif ?>
                        </td>
                        <td><?= \app\models\User::getUserAge($member->user_id->birth_date) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>
        <?php if(\app\models\User::isAdmin()) : ?>
            <div class="row center">
                <a class="btn indigo darken-3 waves-effect waves-light" href="<?= Url::to(['members/reset']) ?>" onclick="return confirm('Точно обнулить баллы?')">
                    <i class="material-icons notranslate left">autorenew</i> Обнулить баллы за другое и месяц
                </a>
            </div>
            <div id="modal1" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <div class="row">
                        <h5 class="col l6 s12">Баллы <b><a href="<?= Url::to(['site/profile']) ?>" id="nickname" target="_blank">[Volvo Trucks] nickname</a></b></h5>
                        <h5 class="col l6 s12">
                            <a id="edit-link" target="_blank" class="btn indigo waves-effect waves-light" href="#">
                                <i class="material-icons notranslate left">edit</i>Редактировать данные водителя
                            </a>
                        </h5>
                    </div>
                    <div class="divider"></div>
                    <div class="row modal-member-scores">
                        <div class="col l4 s4 center">
                            <h5>Другое:</h5>
                            <b><span id="other-scores">66</span></b>
                        </div>
                        <div class="col l4 s4 center">
                            <h5>Месяц:</h5>
                            <b><span id="month-scores">0</span></b>
                        </div>
                        <div class="col l4 s4 center">
                            <h5>Всего:</h5>
                            <b><span id="total-scores">666</span></b>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <h5 class="col s12">Начислить баллы:</h5>
                        <div class="col l6 s12 text-center">
                            <h6 class="center"><b>В другое:</b></h6>
                            <div class="center">
                                <button class="btn indigo waves-effect waves-light add-scores" data-scores="20" data-target="other">
                                    <i class="material-icons notranslate left">add</i>20 баллов
                                </button>
                                <span class="scores-description">За сторонний конвой</span>
                            </div>
                            <div class="center">
                                <button class="btn indigo waves-effect waves-light add-scores" data-scores="10" data-target="other">
                                    <i class="material-icons notranslate left">add</i>10 баллов
                                </button>
                                <span class="scores-description">За сторонний конвой, за сданный экзамен</span>
                            </div>
                            <div class="center">
                                <button class="btn indigo waves-effect waves-light add-scores" data-scores="5" data-target="other">
                                    <i class="material-icons notranslate left">add</i>5 баллов
                                </button>
                            </div>
                        </div>
                        <div class="col l6 s12">
                            <h6 class="center"><b>В месяц:</b></h6>
                            <div class="center">
                                <button class="btn indigo waves-effect waves-light add-scores" data-scores="20" data-target="month">
                                    <i class="material-icons notranslate left">add</i>20 баллов
                                </button>
                                <span class="scores-description">За открытый/совместный конвой</span>
                            </div>
                            <div class="center">
                                <button class="btn indigo waves-effect waves-light add-scores" data-scores="10" data-target="month">
                                    <i class="material-icons notranslate left">add</i>10 баллов
                                </button>
                                <span class="scores-description">За половину открытого/совместного конвоя, внутренний конвой</span>
                            </div>
                            <div class="center">
                                <button class="btn indigo waves-effect waves-light add-scores" data-scores="5" data-target="month">
                                    <i class="material-icons notranslate left">add</i>5 баллов
                                </button>
                                <span class="scores-description">За половину внутреннего конвоя</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a style="cursor: pointer;" class="modal-action modal-close waves-effect btn-flat">Закрыть</a>
                </div>
            </div>
        <?php endif ?>
    </div>
<?php if(\app\models\User::isAdmin()): ?>
    <script>
        $(document).ready(function(){
            var steamid64 = {
            <?php foreach ($all_members as $members):
            foreach ($members as $member): ?>
            <?= $member->user_id->id ?> : <?= $member->user_id->steamid ?>,
            <?php endforeach;
            endforeach; ?>
        }
            var timer = setTimeout(function(){
                loadMembersBans(steamid64);
            }, 15000);
            $('button.add-scores, a:not(.notification-btn)').click(function(){
                clearTimeout(timer);
            });
        });
    </script>
<?php endif ?>