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
            <h5 class="light">[Volvo Trucks] <?= $model->nickname ?></h5>
            <div class="card-panel grey lighten-4">
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
                    <?= $form->field($model, 'start_date', ['template' => '{label}{input}'])->input('date', ['class' => 'datepicker-member-start'])->label('Дата вступления') ?>
                    <script>
                        $datepicker = $('.datepicker-member-start').pickadate({
                            max: true,
                            today: 'Сегодня',
                            clear: 'Очистить',
                            close: 'Закрыть',
                            monthsFull: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                            monthsShort: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                            weekdaysFull: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
                            weekdaysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                            selectMonths: true, // Creates a dropdown to control month
                            selectYears: 60, // Creates a dropdown of 15 years to control year
                            firstDay: 'Понедельник',
                            formatSubmit: 'yyyy-mm-dd',
                            hiddenName: true
                        });
                        <?php if($model->start_date) : ?>
                        var picker = $datepicker.pickadate('picker');
                        picker.set('select', '<?= $model->start_date ?>', { format: 'yyyy-mm-dd' });
                        <?php endif; ?>
                    </script>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <?= $form->field($model, 'additional')->textarea(['class' => 'materialize-textarea']) ?>
                <div class="col s11">
                    <?= $form->field($model, 'vacation', ['template' => '{label}{input}'])->input('date', ['class' => 'datepicker-member'])->label('Отпуск до') ?>
                    <script>
                        $datepicker = $('.datepicker-member').pickadate({
                            today: 'Сегодня',
                            clear: 'Очистить',
                            close: 'Закрыть',
                            monthsFull: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                            monthsShort: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                            weekdaysFull: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
                            weekdaysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                            selectMonths: true, // Creates a dropdown to control month
                            selectYears: 60, // Creates a dropdown of 15 years to control year
                            firstDay: 'Понедельник',
                            formatSubmit: 'yyyy-mm-dd',
                            hiddenName: true
                        });
                        <?php if($model->vacation) : ?>
                        var picker = $datepicker.pickadate('picker');
                        picker.set('select', '<?= $model->vacation ?>', { format: 'yyyy-mm-dd' });
                        <?php endif; ?>
                    </script>
                </div>
                <?= $form->field($model, 'vacation_undefined', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Неопределенный срок') ?>
            </div>
        </div>
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
                    <?= $form->field($model, 'birth_date', ['template' => '{label}{input}'])->input('date', ['class' => 'datepicker-member-birth-date'])->label('Дата рождения') ?>
                    <script>
                        $datepicker = $('.datepicker-member-birth-date').pickadate({
                            min: new Date(1950,1,1),
                            max: true,
                            today: 'Сегодня',
                            clear: 'Очистить',
                            close: 'Закрыть',
                            monthsFull: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                            monthsShort: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                            weekdaysFull: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
                            weekdaysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                            selectMonths: true, // Creates a dropdown to control month
                            selectYears: 60, // Creates a dropdown of 15 years to control year
                            firstDay: 'Понедельник',
                            formatSubmit: 'yyyy-mm-dd',
                            hiddenName: true
                        });
                        <?php if($model->birth_date != '0000-00-00'): ?>
                        var picker = $datepicker.pickadate('picker');
                        picker.set('select', '<?= $model->birth_date ?>', { format: 'yyyy-mm-dd' });
                        <?php endif ?>
                    </script>
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