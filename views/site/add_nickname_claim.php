<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Подать заявление на смену ника - Volvo Trucks';
?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <div class="input-field">
                    <?= $form->field($model, 'new_nickname')->textInput() ?>
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