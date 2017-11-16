<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить конвой - Volvo Trucks';
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/cities.js?t='.time(),  ['position' => yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/select2.min.js?t='.time(),  ['position' => yii\web\View::POS_HEAD, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2.min.css?t='.time());
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2-custom.css?t='.time());
$this->registerJsFile(Yii::$app->request->baseUrl.'/lib/ck-editor/ckeditor.js?t='.time(),  ['position' => yii\web\View::POS_HEAD]);
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
                    <div class="btn indigo darken-3">
                        <span>Выбрать изображение</span>
                        <?= $form->field($model, 'picture_full')->fileInput()->label(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <div class="file-field">
                    <div class="btn indigo darken-3">
                        <span>Выбрать уменьшеное изображение</span>
                        <?= $form->field($model, 'picture_small')->fileInput()->label(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'title')->textInput() ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'description')->textarea() ?>
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
                <h5 class="light">Сборы</h5>
                <?= $form->field($model, 'date')->input('date', ['class' => 'datepicker-convoy'])->error(false) ?>
                <?= $form->field($model, 'meeting_time')->input('time')->error(false) ?>
                <?= $form->field($model, 'departure_time')->input('time')->error(false) ?>
                <?= $form->field($model, 'server')->dropdownList($servers)->error(false) ?>
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
                        '21' => 'Вариация №2.1',
                        '22' => 'Вариация №2.2',
                        '3' => 'Вариация №3',
                        '4' => 'Вариация №1 или №3',
                        '5' => 'Тягач, как в описании',
                        '6' => 'Легковой автомобиль Scout',
                    ])->label(false)->error(false) ?>
                </div>
                <div class="row inner" style="padding-bottom: 20px;">
                    <div class="col l11 s10">
                        <label class="control-label">Прицепы</label>
                        <?= $form->field($model, 'trailer')
                            ->dropdownList($trailers, [
                                'id' => 'trailer-select-0',
                                'class' => 'browser-default trailers-select',
                                'data-target' => 'trailers'])
                            ->error(false)
                            ->label(false) ?>
                    </div>
                    <div class="col l1 s2 center add-btn-container" style="line-height: 66px;">
                        <button class="tooltipped indigo-text add-trailer" data-position="bottom" data-tooltip="Добавить прицеп">
                            <i class="material-icons notranslate small">add</i>
                        </button>
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
                <div id="trailer-info" class="row">
                    <div class="trailer-preview col s12">
                        <img src="<?= Yii::$app->request->baseUrl ?>/images/trailers/default.jpg" class="responsive-img z-depth-2" id="trailer-image-0">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="input-field file-field">
                    <div class="btn indigo darken-3 waves-effect waves-light">
                        <span>Дополнительное изображение</span>
                        <?= $form->field($model, 'extra_picture')->fileInput()->label(false)->error(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
                <div class="input-field file-field">
                    <h6 class="light">Дополнительная информация</h6>
                    <?= $form->field($model, 'add_info')->textarea(['class' => 'materialize-textarea', 'id' => 'add_info'])->label(false) ?>
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
<script type="text/javascript">
    CKEDITOR.replace('add_info');
</script>
<script>
    $('#trailer-select-0').select2();
</script>