<?php

use yii\helpers\Url;

$this->title = 'Статистика Volvo Trucks';

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
                <th colspan="2">Экзамены</th>
                <th>Возраст</th>
                <th>Дополнительно</th>
                <?php if(\app\models\User::isAdmin()) : ?>
                    <th></th>
                <?php endif ?>
            </tr>
            </thead>
            <?php $i = 1;
            $last_position = end($all_members);
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
                    <th>Парковка</th>
                    <th>Вождение</th>
                    <th></th>
                    <th><?php if($members == $last_position) : ?>
                        В компании с:
                    <?php endif ?></th>
                    <?php if(\app\models\User::isAdmin()) : ?>
                        <th></th>
                    <?php endif ?>
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
                                <span><?= $member->scores_other == '0' ? '' : $member->scores_other ?></span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                                <span><?= $member->scores_month == '0' ? '' : $member->scores_month ?></span>
                            <?php endif ?>
                        </td>
                        <td>
                            <?php if($member->post_id->admin == 1) : ?>
                                <span>&mdash;</span>
                            <?php else: ?>
                            <?php if(\app\models\User::isAdmin()) : ?>
                                <?php $scores_updated = null;
                                    if($member->scores_updated){
                                        $scores_date = new DateTime($member->scores_updated);
                                        $scores_updated = $scores_date->format('d.m.y H:i');
                                    } ?>
                                <?php endif ?>
                                <span<?php if($scores_updated): ?> class="tooltipped" data-tooltip="Обновлено: <?= $scores_updated ?>" data-delay="0"<?php endif ?>>
                                    <b><?= $member->scores_total == '0' ? '' : $member->scores_total ?></b>
                                </span>
                            <?php endif ?>
                        </td>
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
                        <td><?php if($member->post_id->id == '1') : ?>
                            <?= \app\controllers\SiteController::getRuDate($member->start_date) ?>
                        <?php else: ?>
                            <?= $member->additional ?>
                        <?php endif ?></td>
                        <?php if(\app\models\User::isAdmin()) : ?>
                            <td><a href="<?= Url::to(['members/edit', 'id' => $member->id]) ?>" class="indigo-text iconed notranslate">edit</a></td>
                        <?php endif ?>
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
        <?php endif ?>
    </div>
<?php if(\app\models\User::isAdmin()): ?>
    <script>
        $(document).ready(function(){
            var steamid64 = {
            <?php foreach ($all_members as $members):
                foreach ($members as $member):
                    if($member->user_id->steamid) : ?>
                        <?= $member->user_id->id ?> : <?= $member->user_id->steamid ?>,
                    <?php endif;
                endforeach;
            endforeach; ?>
        }
            var timer = setTimeout(function(){
                loadMembersBans(steamid64);
            }, 20000);
            $('a:not(.notification-btn)').click(function(){
                clearTimeout(timer);
            });
        });
    </script>
<?php endif ?>