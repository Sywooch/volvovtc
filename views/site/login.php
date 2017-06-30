<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Войти на сайт - Volvo Trucks';
?>
<div class="container login-container">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "<div class=\"input-field col l9 s10\">{label}{input}</div>",
            'options' => ['class' => 'row']
        ],
    ]); ?>
    <div class="card">
        <div class="card-image no-img" style="background-image: url(assets/img/login.jpg)">
            <span class="card-title text-shadow">Вход на сайт</span>
        </div>
        <div class="card-content">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин или E-Mail') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль')  ?>
            <?= $form->field($model, 'rememberMe', ['template' => '<div>{input}{label}</div>'])
                ->checkbox(['label' => null])->error(false)->label('Запомнить') ?>
        </div>
        <div class="card-action">
            <?=Html::submitButton('Войти '.
                Html::tag('i', 'send', ['class' => 'material-icons right']), [
                'class' => 'btn indigo darken-3 waves-effect waves-light'
            ])?>
            <a href="<?=Url::to(['site/signup'])?>" class="btn-flat waves-effect">
                <i class="material-icons right">add</i>Зарегистрироваться
            </a>
            <a href="#modal1" class="btn-flat waves-effect right">Забыли пароль?</a>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<div id="modal1" class="modal reset-pwd">
    <div class="modal-content row">
        <h4>Сброс пароля</h4>
        <p>Укажите свой E-Mail, и мы отправим Вам ссылку для сброса пароля.</p>
        <div class="input-field col s9">
            <input id="email" type="email" class="validate">
            <label for="email" data-error="Укажите правильный E-Mail" data-success="">Ваш E-Mail</label>
        </div>
        <div class="input-field col s2 preloader"></div>
    </div>
    <div class="modal-footer">
        <a href="#" class="modal-action modal-close waves-effect btn-flat indigo-text text-darken-3">Закрыть</a>
        <a href="#" class="send-reset waves-effect btn-flat indigo-text text-darken-3">Далее</a>
    </div>
</div>
<?php if($model->hasErrors()) :
    //Kint::dump($model->errors)?>
    <script>
        <?php foreach ($model->errors as $error): ?>
        Materialize.toast('<?= $error[0] ?>', 6000);
        <?php endforeach; ?>
    </script>
<?php endif ?>