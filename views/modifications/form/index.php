<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = (Yii::$app->controller->action->id == 'add' ? 'Добавить' : 'Редактировать') .' модификацию - Volvo Trucks';
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/select2.min.js?t='.time(),  ['position' => yii\web\View::POS_HEAD, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2.min.css?t='.time());
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2-custom.css?t='.time());
?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <h5 class="light col l12 s12"><?= Yii::$app->controller->action->id == 'add' ? 'Добавление' : 'Редактирование' ?> модификации</h5>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">Изображение/прицеп</h5>
                <div class="row">
                    <div class="col l11 s10">
                        <?= $form->field($model, 'trailer')
                            ->dropdownList($trailers, [
                                'id' => 'trailer-select-0',
                                'class' => 'browser-default trailers-select',
                                'data-target' => 'mods'])
                            ->error(false)
                            ->label(false) ?>
                    </div>
                    <div class="col l1 s2 center" style="line-height: 66px;">
                        <a href="<?= Url::to(['site/trailers', 'action' => 'add']) ?>" class="tooltipped indigo-text" data-position="bottom" data-tooltip="Добавить новый трейлер">
                            <i class="material-icons notranslate small">add</i>
                        </a>
                    </div>
                </div>
                <div class="input-field file-field">
                    <div class="btn indigo darken-3 waves-effect waves-light">
                        <span>Изображение</span>
                        <?= $form->field($model, 'picture')->fileInput()->label(false)->error(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Выбрать, если не прицеп">
                    </div>
                </div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <div id="trailer-info">
                    <?php if(Yii::$app->controller->action->id == 'add'){
                        require_once 'trailer_data_add.php';
                    }else{
                        require_once 'trailer_data_edit.php';
                    } ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">Основная информация</h5>
                <?= $form->field($model, 'category')->dropDownList($categories)->error(false) ?>
                <div class="input-field">
                    <?= $form->field($model, 'title')->textInput()->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'description')->textarea(['class' => 'materialize-textarea'])->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'warning')->textarea(['class' => 'materialize-textarea'])->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'author')->textInput()->error(false) ?>
                </div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5 class="light">Ссылки на скачивание</h5>
                <label>Файл модификации</label>
                <div class="file-field">
                    <div class="btn indigo darken-3 waves-effect waves-light">
                        <span>Файл</span>
                        <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path" type="text" value="<?= $model->file_name ?>" disabled>
                    </div>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'yandex_link')->textInput()->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'gdrive_link')->textInput()->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'mega_link')->textInput()->error(false) ?>
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
    $('#trailer-select-0').select2();
</script>