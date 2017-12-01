<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Редактирование информации о водителе - Volvo Trucks'; ?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'id' => 'member-form',
            'fieldConfig' => [
            'template' => "<div class=\"input-field col l11 s11\">{label}{input}</div>",
            'options' => ['class' => 'row'],
            'inputOptions' => ['autocomplete' => 'Off']
        ]]);?>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">[Volvo Trucks] <?= $model->nickname ?></h5>
                <label>Должность</label>
                <?= $form->field($model, 'post_id')->dropdownList([
                    '1' => 'Испытательный срок',
                    '2' => 'Стажер',
                    '3' => '3 категория',
                    '4' => '2 категория',
                    '5' => '1 категория',
                    '6' => 'Легенда',
                    '7' => 'Логист',
                    '8' => 'Отдел кадров',
                    '9' => 'Инструктор',
                    '10' => 'Заместитель директора',
                    '11' => 'Директор',
                ])->error(false)->label(false) ?>
                <div class="col s11">
                    <?= $form->field($model, 'start_date', ['template' => '{label}{input}'])
                        ->input('date', [
                            'class' => 'datepicker-member-start',
                            'data-value' => $model->start_date
                        ])
                        ->label('Дата вступления') ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <?= $form->field($model, 'additional')->textarea(['class' => 'materialize-textarea']) ?>
                <div class="col s11">
                    <?= $form->field($model, 'vacation', ['template' => '{label}{input}'])
                        ->input('date', [
                            'class' => 'datepicker-vacation',
                            'data-value' => $model->vacation
                        ])
                        ->label('Отпуск до') ?>
                </div>
                <?= $form->field($model, 'vacation_undefined', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Неопределенный срок') ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col l6 s12" style="padding: 0">
            <div class="col s12">
                <div class="card-panel grey lighten-4">
                    <h5 class="light">Возможности</h5>
                    <?= $form->field($model, 'can_lead', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->error(false)->label('Ведущий') ?>
                    <?= $form->field($model, 'can_center', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->error(false)->label('Центральный') ?>
                    <?= $form->field($model, 'can_close', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->error(false)->label('Замыкающий') ?>
                </div>
            </div>
            <div class="col s12">
                <div class="card-panel grey lighten-4">
                    <h5 class="light">Экзамены</h5>
                    <?= $form->field($model, 'exam_driving', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->error(false)->label('Вождение') ?>
                    <?= $form->field($model, 'exam_3_cat', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->error(false)->label('3 категория') ?>
                    <?= $form->field($model, 'exam_2_cat', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->error(false)->label('2 категория') ?>
                    <?= $form->field($model, 'exam_1_cat', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->error(false)->label('1 категория') ?>
                </div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">Баллы</h5>
                <?= $form->field($model, 'scores_total')->input('number') ?>
                <?= $form->field($model, 'scores_month')->input('number') ?>
                <?= $form->field($model, 'scores_other')->input('number') ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4 ">
                <h5 class="light">Информация профиля</h5>
                <?= $form->field($model, 'first_name')->textInput() ?>
                <?= $form->field($model, 'last_name')->textInput() ?>
                <div class="col s11">
                    <?= $form->field($model, 'birth_date', ['template' => '{label}{input}'])
                        ->input('date', [
                            'class' => 'datepicker-profile',
                            'data-value' => $model->birth_date != '0000-00-00' ? $model->birth_date : null
                        ])->label('Дата рождения') ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4 ">
                <?= $form->field($model, 'vk')->textInput() ?>
                <?= $form->field($model, 'steam')->textInput() ?>
                <?= $form->field($model, 'truckersmp')->textInput(['readonly' => 'readonly']) ?>
                <?= $form->field($model, 'nickname')->textInput() ?>
            </div>
        </div>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">Уведомить сотрудника о:</h5>
                <?= $form->field($model, 'notify[increase]', [
                        'template' => '{input}{label}',
                        'options' => [
                            'tag' => false
                        ]
                    ])->checkbox(['label' => null])->error(false)->label('Повышении') ?>
                <?= $form->field($model, 'notify[decrease]', [
                    'template' => '{input}{label}',
                    'options' => [
                        'tag' => false
                    ]
                ])->checkbox(['label' => null])->error(false)->label('Понижении') ?>
                <?= $form->field($model, 'notify[profile]', [
                    'template' => '{input}{label}',
                    'options' => [
                        'tag' => false
                    ]
                ])->checkbox(['label' => null])->error(false)->label('Изменении данных профиля') ?>
                <?= $form->field($model, 'notify[scores+]', [
                    'template' => '{input}{label}',
                    'options' => [
                        'tag' => false
                    ]
                ])->checkbox(['label' => null])->error(false)->label('Начислении баллов') ?>
                <?= $form->field($model, 'notify[scores-]', [
                    'template' => '{input}{label}',
                    'options' => [
                        'tag' => false
                    ]
                ])->checkbox(['label' => null])->error(false)->label('Списании баллов') ?>
                <?= $form->field($model, 'notify[ability]', [
                    'template' => '{input}{label}',
                    'options' => [
                        'tag' => false
                    ]
                ])->checkbox(['label' => null])->error(false)->label('Изменении возможностей') ?>
                <?= $form->field($model, 'notify[custom]')->textInput(['maxlength' => '255'])->label('Кастомный текст') ?>
            </div>
        </div>
        <div class="col s12">
            <ul class="collapsible grey lighten-4">
                <li>
                    <div class="collapsible-header grey lighten-4"><i class="material-icons">stars</i>Достижения сотрудника</div>
                    <div class="collapsible-body">
                        <table class="member-achievements highlight">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th class="center">Описание</th>
                                    <th class="center">Этапов выполнено</th>
                                    <th class="center">Всего этапов</th>
                                    <th class="center">Выполнено</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_achievements as $achievement):
                                    $complete = in_array($achievement->id, $model->achievements) ?>
                                    <tr class="achievement">
                                        <td>
                                            <a href="<?= Url::to(['achievements/edit', 'id' => $achievement->id]) ?>" class="truncate">
                                                <?= $achievement->title ?></a>
                                        </td>
                                        <td class="truncate center"><?= $achievement->description ?></td>
                                        <td class="center">
                                            <?php $count = 0;
                                            foreach ($achievements_progress as $ach){
                                                if($ach['ach_id'] == $achievement->id) $count++;
                                            }?>
                                            <?= $count ?>
                                        </td>
                                        <td class="center"><?= $achievement->progress ?></td>
                                        <td class="center">
                                            <?= $form->field($model, 'achievements['.$achievement->id.']', [
                                                'template' => '{input}{label}',
                                                'options' => [
                                                    'tag' => false
                                                ]
                                            ])->checkbox(['label' => null])->error(false)->label('') ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </li>
            </ul>
        </div>
        <?php if($model->scores_history) :
        $scores = unserialize($model->scores_history); ?>
            <div class="col s12">
                <div class="card-panel grey lighten-4">
                    <h5 class="light">История баллов</h5>
                    <table class="highlight">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th class="center">Другое</th>
                                <th class="center">Месяц</th>
                                <th class="center">Всего</th>
                                <th class="center">Выставил</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($scores as $item) :
                                $date = new DateTime($item['date']); ?>
                                <tr>
                                    <td><?= $date->format('d.m.y H:i') ?></td>
                                    <td class="center"><?= $item['other'] ?></td>
                                    <td class="center"><?= $item['month'] ?></td>
                                    <td class="center"><?= $item['total'] ?></td>
                                    <td class="grey-text center">
                                        <?php if(isset($item['admin'])){
                                            $admin = \app\models\User::findOne($item['admin']); ?>
                                            [Volvo Trucks] <?= $admin->nickname ?>
                                        <?php } else { ?>
                                            &mdash;
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
            </div>
            </div>
        <?php endif ?>
        <div class="fixed-action-btn vertical">
            <?=Html::submitButton(''.
                Html::tag('i', 'save', ['class' => 'material-icons notranslate right']), [
                'class' => 'btn-floating btn-large red waves-effect waves-light tooltipped',
                'name' => 'save_member',
                'data-position' => 'left',
                'data-tooltip' => 'Сохранить'
            ]); ?>
            <ul>
                <li>
                    <a href="<?=Url::to([
                        'members/dismiss',
                        'id' => $model->id
                    ])?>" class="btn-floating yellow darken-3 tooltipped" data-position="left" data-tooltip="Уволить" onclick='return confirm("Уволить водителя?")'>
                        <i class="material-icons notranslate">clear</i>
                    </a>
                </li>
            </ul>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>