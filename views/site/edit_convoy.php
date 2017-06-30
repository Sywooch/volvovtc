<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать конвой - Volvo Trucks';
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/cities.js?t='.time(),  ['position' => yii\web\View::POS_END]);
?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <h5>Основная информация</h5>
                <label>Карта маршрута</label>
                <div class="file-field">
                    <div class="btn indigo darken-3 waves-effect waves-light">
                        <span>Выбрать новое изображение</span>
                        <?= $form->field($model, 'picture_full')->fileInput() ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Оригинальное изображение">
                    </div>
                </div>
                <div class="file-field">
                    <div class="btn indigo darken-3">
                        <span>Выбрать уменьшеное изображение</span>
                        <?= $form->field($model, 'picture_small')->fileInput()->label(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Рекомендуется, если размер оригинала больше 5Мб">
                    </div>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'title')->textInput() ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'description')->textarea() ?>
                </div>
                <div class="input-field center">
                    <?= $form->field($model, 'dlc[Going East!]', [
                        'template' => '{input}{label}',
                        'options' => [
                            'tag' => false
                        ]
                    ])->checkbox(['label' => null])->error(false)->label('DLC Going East!') ?>
                    <?= $form->field($model, 'dlc[Scandinavia]', [
                        'template' => '{input}{label}',
                        'options' => [
                            'tag' => false
                        ]
                    ])->checkbox(['label' => null])->error(false)->label('DLC Scandinavia!') ?>
                    <?= $form->field($model, 'dlc[Viva La France!]', [
                        'template' => '{input}{label}',
                        'options' => [
                            'tag' => false
                        ]
                    ])->checkbox(['label' => null])->error(false)->label('DLC Viva La France!') ?>
                </div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5>Сборы</h5>
                <?= $form->field($model, 'date')->input('date', ['class' => 'datepicker-edit-convoy'])->error(false) ?>
                <script>
                    $datepicker = $('.datepicker-edit-convoy').pickadate({
                        min: new Date(2000,1,1),
                        today: 'Сегодня',
                        clear: 'Очистить',
                        close: 'Закрыть',
                        monthsFull: ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'],
                        monthsShort: ['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                        weekdaysFull: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
                        weekdaysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                        selectMonths: true, // Creates a dropdown to control month
                        selectYears: 60, // Creates a dropdown of 15 years to control year
                        firstDay: 'Понедельник',
                        formatSubmit: 'yyyy-mm-dd'
                    });
                    var picker = $datepicker.pickadate('picker');
                    picker.set('select', '<?= $model->date ?>', { format: 'yyyy-mm-dd' });
                </script>
                <?= $form->field($model, 'meeting_time')->input('time', ['class' => 'timepicker'])->error(false) ?>
                <?= $form->field($model, 'departure_time')->input('time', ['class' => 'timepicker'])->error(false) ?>
                <?= $form->field($model, 'server')->dropdownList([
                    'ETS2' => [
                        'eu1' => 'Европа 1',
                        'eu2_ets' => 'Европа 2',
                        'eu3' => 'Европа 3',
                        'eu5' => 'Европа 5',
                        'us_ets' => 'United States',
                        'sa' => 'South America',
                        'hk' => 'Honk Kong',
                    ],
                    'ATS' => [
                        'eu2_ats' => 'Европа 2',
                        'us_ats' => 'United States',
                    ]
                ])->error(false) ?>
                <div class="input-field">
                    <?= $form->field($model, 'communications')->textInput()->error(false) ?>
                </div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5>Маршрут</h5>
                <div class="input-field">
                    <?= $form->field($model, 'start_city')->textInput(['class' => 'autocomplete-city', 'autocomplete' => 'off'])->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'start_company')->textInput(['class' => 'autocomplete-company', 'autocomplete' => 'off'])->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'finish_city')->textInput(['class' => 'autocomplete-city', 'autocomplete' => 'off'])->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'finish_company')->textInput(['class' => 'autocomplete-company', 'autocomplete' => 'off'])->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'rest')->textInput()->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'length')->textInput()->error(false) ?>
                </div>
            </div>
        </div>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <h5>Дополнительная информация</h5>
                <div class="row">
                    <div class="input-field col l6 s12">
                        <?= $form->field($model, 'truck_var')->dropdownList([
                            '0' => 'Любая вариация',
                            '1' => 'Вариация №1',
                            '2' => 'Вариация №2',
                            '3' => 'Вариация №3',
                            '4' => 'Вариация №1 или №3',
                            '5' => 'Кастомный тягач'
                        ])->label(false)->error(false) ?>
                    </div>
                    <div class="input-field col l6 s12">
                        <?= $form->field($model, 'trailer_name')->textInput()->error(false) ?>
                    </div>
                </div>
                <label>Изображение прицепа/груза</label>
                <div class="file-field">
                    <div class="btn indigo darken-3 waves-effect waves-light">
                        <span>Выбрать новое изображение</span>
                        <?= $form->field($model, 'trailer_picture')->fileInput()->label(false)->error(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <?= $form->field($model, 'open', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->label('Это открытый конвой') ?>
                <?= $form->field($model, 'visible', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->label('Сделать конвой видимым') ?>
            </div>
        </div>
        <div class="fixed-action-btn">
            <?=Html::submitButton(Html::tag('i', 'save', [
                    'class' => 'large material-icons'
            ]), ['class' => 'btn-floating btn-large red']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>