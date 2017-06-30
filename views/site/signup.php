<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Зарегистрироваться - Volvo Trucks';
$this->registerJsFile('https://www.google.com/recaptcha/api.js', ['position' => yii\web\View::POS_HEAD])
?>
<div class="container login-container">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "<div class=\"input-field col s11\">{label}{input}</div>",
            'options' => ['class' => 'row']
        ],
    ]); ?>
    <div class="card">
        <div class="card-image no-img" style="background-image: url(assets/img/signup.jpg)">
            <span class="card-title text-shadow">Регистрация на сайте</span>
        </div>
        <div class="card-content row">
            <div class="col l6 s12">
                <?= $form->field($model, 'first_name')->textInput()->label('Имя') ?>
                <?= $form->field($model, 'last_name')->textInput()->label('Фамилия') ?>
                <?= $form->field($model, 'username')->textInput()->label('*Логин')->error(false) ?>
                <?= $form->field($model, 'email')->input('email')->label('*E-Mail')->error(false) ?>
                <?= $form->field($model, 'visible_email', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Сделать E-Mail видимым для всех') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('*Пароль (мин. 6 символов)')->error(false) ?>
                <?= $form->field($model, 'password_2')->passwordInput()->label('*Повторите пароль (мин. 6 символов)')->error(false) ?>
                <?= $form->field($model, 'nickname')->textInput()->label('Ваш игровой псевдоним') ?>
                <div class="g-recaptcha" data-sitekey="6LfjRyIUAAAAAJeHEkWoN3zT2lND2N7D2fPy8Nwv"></div>
            </div>
            <div class="col l6 s12">
                <?= $form->field($model, 'country')->textInput()->label('Страна') ?>
                <?= $form->field($model, 'city')->textInput()->label('Город') ?>
                <?= $form->field($model, 'birth_date')->input('date', ['class' => 'datepicker'])->label('Дата рождения') ?>
                <?= $form->field($model, 'vk')->textInput()->label('Профиль VK') ?>
                <?= $form->field($model, 'steam')->textInput()->label('Профиль Steam') ?>
                <?= $form->field($model, 'steamid64')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'visible_truckersmp', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox([
                        'label' => null,
                        'disabled' => $model->steamid64 == '' ? 'true' : false
                    ])->error(false)->label('Показать профиль TruckersMP') ?>
                <?php $display = $model->visible_truckersmp ? 'block' : 'none' ?>
                <?= $form->field($model, 'truckersmp')->textInput(['style' => 'display: '.$display, 'readonly' => true])->label(false) ?>
                <?= $form->field($model, 'company')->textInput()->label('В какой ВТК вы состоите') ?>
                <?= $form->field($model, 'has_ets', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Есть <b>Euro Truck Simulator 2</b>') ?>
                <?= $form->field($model, 'has_ats', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Есть <b>American Truck Simulator</b>') ?>
            </div>
        </div>
        <div class="card-action">
            <?=Html::submitButton('Зарегистрироваться '.
                Html::tag('i', 'send', ['class' => 'material-icons right']), [
                'class' => 'btn indigo darken-3 waves-effect waves-light'
            ])?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php if($model->hasErrors()) :
    //Kint::dump($model->errors)?>
    <script>
        <?php foreach ($model->errors as $error): ?>
        Materialize.toast('<?= $error[0] ?>', 6000);
        <?php endforeach; ?>
    </script>
<?php endif ?>