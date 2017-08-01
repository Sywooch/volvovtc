<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать конвой - Volvo Trucks';
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/cities.js?t='.time(),  ['position' => yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/select2.min.js?t='.time(),  ['position' => yii\web\View::POS_HEAD, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2.min.css?t='.time());
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2-custom.css?t='.time());
?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">Основная информация</h5>
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
                    <?= $form->field($model, 'description')->textarea(['class' => 'materialize-textarea']) ?>
                </div>
                <div class="center">
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
                    ])->checkbox(['label' => null])->error(false)->label('DLC Scandinavia') ?>
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
                <h5 class="light">Сборы</h5>
                <?= $form->field($model, 'date')->input('date', ['class' => 'datepicker-edit-convoy'])->error(false) ?>
                <script>
                    $datepicker = $('.datepicker-edit-convoy').pickadate({
                        min: new Date(2000,1,1),
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
                <h5 class="light">Маршрут</h5>
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
        <div class="clearfix"></div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">Дополнительная информация</h5>
                <div class="input-field">
                    <?= $form->field($model, 'truck_var')->dropdownList([
                        '0' => 'Любая вариация',
                        '1' => 'Вариация №1',
                        '2' => 'Вариация №2',
                        '3' => 'Вариация №3',
                        '4' => 'Вариация №1 или №3',
                        '5' => 'Кастомный тягач'
                    ])->label(false)->error(false) ?>
                </div>
                <div class="row">
                    <div class="col l11 s10">
                        <?= $form->field($model, 'trailer')->dropdownList($trailers, ['id' => 'trailer-select', 'class' => 'browser-default', 'data-target' => 'trailers'])->error(false)->label(false) ?>
                    </div>
                    <div class="col l1 s2 center" style="line-height: 66px;">
                        <a target="_blank" href="<?= Url::to(['site/trailers', 'action' => 'add']) ?>" class="tooltipped indigo-text" data-position="bottom" data-tooltip="Добавить новый трейлер">
                            <i class="material-icons notranslate small">add</i>
                        </a>
                    </div>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'author')->textInput() ?>
                </div>
                <?= $form->field($model, 'open', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->label('Это открытый конвой (будет виден гостям)') ?>
                <?= $form->field($model, 'visible', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->label('Сделать конвой видимым') ?>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <div id="trailer-info">
                    <h6 class="light" id="trailer-name" style="font-weight: bold;">
                        <?= $trailer_data['name'] ?>
                    </h6>
                    <span class="light" id="trailer-description"><?= $trailer_data['description'] ?></span>
                    <img src="<?= Yii::$app->request->baseUrl . '/images/' . $trailer_data['image'] ?>" class="responsive-img z-depth-2" id="trailer-image">
                </div>
                <?php if($model->extra_picture) : ?>
                    <img src="<?= Yii::$app->request->baseUrl . '/images/convoys/' . $model->extra_picture ?>" class="responsive-img z-depth-2">
                    <a href="<?= Url::to(['site/convoys', 'action' => 'delete_extra_picture', 'id' => $_GET['id']]) ?>" class="btn indigo darken-3 waves-effect waves-light" onclick="return confirm('Удалить дополнительное изображение?')">
                        <i class="material-icons notranslate left">clear</i>Удалить
                    </a>
                <?php endif ?>
                <div class="input-field file-field">
                    <div class="btn indigo darken-3 waves-effect waves-light">
                        <i class="material-icons notranslate left">add</i>
                        <span>Дополнительное изображение</span>
                        <?= $form->field($model, 'extra_picture')->fileInput()->label(false)->error(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <div class="input-field file-field">
                    <?= $form->field($model, 'add_info')->textarea(['class' => 'materialize-textarea']) ?>
                </div>
            </div>
        </div>
        <div class="fixed-action-btn">
            <?=Html::submitButton(Html::tag('i', 'save', [
                    'class' => 'large material-icons notranslate'
            ]), ['class' => 'btn-floating btn-large red']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
    $('#trailer-select').select2();
</script>