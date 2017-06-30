<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Вступить в Volvo Trucks'; ?>

<div class="container">

    <?php if($step == '1') : ?>

        <div class="card">
            <div class="card-image no-img" style="background-image: url(assets/img/recruit.jpg)">
                <span class="recruit-text-f text-shadow">Вступление в компанию</span>
                <span class="recruit-text-s text-shadow">Шаг 1</span>
            </div>
            <div class="card-content">
                <h5>Перед подачей заявки убедитесь, что:</h5>
                <ol>
                    <li>Ваш профиль Steam открыт для всех <a href="http://steamcommunity.com/profiles/76561198283160497/edit/settings" target="_blank">Открыть</a></li>
                    <li>Ваши личные сообщения ВК открыты для всех <a href="https://vk.com/settings?act=privacy" target="_blank">Открыть</a></li>
                    <li>Ваши профиль на сайте полностью заполнен <a href="<?=Url::to(['site/profile', 'action' => 'edit'])?>" target="_blank">Заполнить</a></li>
                    <li>Вам есть 18 лет. Если Вам нет 18, <a href="https://vk.com/im?sel=105513579" target="_blank">писать сюда</a></li>
                    <li>Вы ознакомились с <a href="<?= Url::to(['site/rules']) ?>" target="_blank">правилами</a></li>
                    <li>Вы не состоите в другой ВТК</li>
                </ol>
            </div>
            <div class="card-action">
                <a href="<?= Url::to(['site/recruit', 'step' => '2']) ?>" class="btn indigo darken-3 waves-effect waves-light">Далее<i class="material-icons right">arrow_forward</i></a>
            </div>
        </div>

    <?php endif ?>

    <?php if($step == '2') : ?>

        <div class="card">
            <div class="card-image no-img" style="background-image: url(assets/img/recruit-2.jpg)">
                <span class="recruit-text-f text-shadow">Вступление в компанию</span>
                <span class="recruit-text-s text-shadow">Шаг 2</span>
            </div>
            <div class="card-content">
                <h5>Прежде, чем подавать заявку на вступление, хорошо прочитайте все правила!</h5>
                <div class="step-2-rules card-panel grey lighten-3">
                    <?= $rules->text ?>
                </div>

                <div><?=Html::checkbox('fulfill', false, ['id' => 'fulfill']).Html::label('Я выполнил все требования', 'fulfill')?></div>
                <div><?=Html::checkbox('read-rules', false, ['id' => 'read-rules']).Html::label('Я ознакомлен с правилами', 'read-rules')?></div>

            </div>
            <div class="card-action">
                <a href="<?= Url::to(['site/recruit', 'step' => '1']) ?>" class="btn indigo darken-3 waves-effect waves-light"><i class="material-icons left">arrow_back</i>Назад</a>
                <a href="<?= Url::to(['site/recruit', 'step' => '3']) ?>" class="btn indigo darken-3 waves-effect waves-light disabled" id="recruit-btn">Далее<i class="material-icons right">arrow_forward</i></a>
            </div>
        </div>

    <?php endif ?>

    <?php if($step == '3') : ?>

        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "<div class=\"input-field col l9 s11\">{label}{input}</div>".
                    "<div class=\"col l3 s1 valign-wrapper helper\">{error}</div>",
                'options' => ['class' => 'row'],
                'inputOptions' => ['autocomplete' => 'Off']
            ],
        ]); ?>
        <div class="card">
            <div class="card-image no-img" style="background-image: url(assets/img/recruit-3.jpg)">
                <span class="recruit-text-f text-shadow">Вступление в компанию</span>
                <span class="recruit-text-s text-shadow">Шаг 3</span>
            </div>
            <div class="card-content">
                <?=$form->field($model, 'invited_by')->textInput()->label('Кто Вас пригласил в ВТК Volvo Trucks?')?>
                <?=$form->field($model, 'hear_from')->textarea(['class' => 'materialize-textarea'])->label('Как вы узнали про ВТК Volvo Trucks?')?>
                <?=$form->field($model, 'comment')->textarea(['class' => 'materialize-textarea'])->label('Ваш комментарий к заявке')?>
            </div>
            <div class="card-action">
                <a href="<?= Url::to(['site/recruit', 'step' => '2']) ?>" class="btn indigo darken-3 waves-effect waves-light"><i class="material-icons left">arrow_back</i>Назад</a>
                <?=Html::submitButton('Подать заявку '.
                    Html::tag('i', 'send', ['class' => 'material-icons right']), [
                    'class' => 'btn indigo darken-3 waves-effect waves-light'
                ])?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    <?php endif ?>

</div>