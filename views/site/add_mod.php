<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить модификацию - Volvo Trucks';

?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <h5>Добавление модификации</h5>
                <label>Изображение</label>
                <div class="file-field">
                    <div class="btn col s3 indigo darken-3">
                        <span>Выбрать изображение</span>
                        <?= $form->field($model, 'picture')->fileInput()->label(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="col l6 s12">
            <div class="card-panel grey lighten-4">
                <h5>Основная информация</h5>
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
                <h5>Ссылки на скачивание</h5>
                <label>Файл модификации</label>
                <div class="file-field">
                    <div class="btn indigo darken-3">
                        <span>Файл</span>
                        <?= $form->field($model, 'file')->fileInput()->label(false) ?>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
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
                    'class' => 'large material-icons'
            ]), ['class' => 'btn-floating btn-large red']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>