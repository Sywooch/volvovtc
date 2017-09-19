<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование профиля - Volvo Trucks';
?>

<div class="container">
    <?php $form = ActiveForm::begin([
            'id' => 'profile-form',
            'fieldConfig' => [
                'template' => "<div class=\"input-field col s11\">{label}{input}</div>",
                'options' => ['class' => 'row'],
                'inputOptions' => ['autocomplete' => 'Off']
            ],
            'options' => ['enctype'=>'multipart/form-data']
        ]);?>
    <div class="card grey lighten-4">
        <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/bg/<?= $user->bg_image ?>)">
            <div class="profile-img z-depth-3" id="preview" style="background-image: url(<?=Yii::$app->request->baseUrl.'/images/users/'.$user->picture.'?t='.time()?>)">
                <label class="overlay valign-wrapper">
                    <i class="material-icons notranslate medium">file_upload</i>
                    <?= $form->field($model, 'picture', [
                        'template' => '<div>{input}{label}</div>',
                        'options' => ['class' => 'false',]
                    ])->fileInput([
                        'id' => 'file_input',
                        'style' => 'display: none',
                        'accept' => 'image/*'
                    ])->label(false) ?>
                </label>
            </div>
            <div class="bg-img">
                <label class="overlay valign-wrapper">
                    <i class="material-icons notranslate medium">file_upload</i>
                    <?= $form->field($model, 'bg_image', [
                        'template' => '<div>{input}{label}</div>',
                        'options' => ['class' => 'false']
                    ])->fileInput([
                        'id' => 'file_input',
                        'style' => 'display: none',
                        'accept' => 'image/*'
                    ])->label(false) ?>
                </label>
            </div>
            <span class="card-title text-shadow">Редактирование профиля</span>
        </div>
        <div class="card-content row">
            <div class="col l6 s12">
                <?= $form->field($model, 'first_name')->textInput([
                    'value' => $user->first_name,
                    'readonly' => $member ? 'true' : false
                ])->label('Имя') ?>
                <?= $form->field($model, 'last_name')->textInput([
                    'value' => $user->last_name,
                    'readonly' => $member ? 'true' : false
                ])->label('Фамилия') ?>
                <?= $form->field($model, 'username')->textInput([
                    'required' => 'required',
                    'value' => Yii::$app->user->identity->username
                ])->label('Логин*')->error(false) ?>
                <?= $form->field($model, 'email')->input('email', [
                    'required' => 'required',
                    'value' => $user->email
                ])->label('E-Mail*')->error(false) ?>
                <?= $form->field($model, 'visible_email', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Сделать E-Mail видимым для всех') ?>
                <?= $form->field($model, 'country')->textInput([
                    'value' => $user->country
                ])->label('Страна') ?>
                <?= $form->field($model, 'city')->textInput([
                    'value' => $user->city
                ])->label('Город') ?>
                <?php if($member) : ?>
                    <div class="row">
                        <div class="input-field col s11">
                            <label>Дата рождения</label>
                            <input type="text" readonly value="<?= \app\controllers\SiteController::getRuDate($user->birth_date) ?>">
                        </div>
                    </div>
                    <?= $form->field($model, 'birth_date')
                        ->hiddenInput(['readonly' => true, 'value' => $user->birth_date])
                        ->label(false) ?>
                <?php else: ?>
                    <div class="col s11">
                        <?= $form->field($model, 'birth_date', ['template' => '{label}{input}'])->input('date', [
                            'class' => 'datepicker',
                            'readonly' => $member ? 'true' : false
                        ])->label('Дата рождения') ?>
                        <script>
                            $datepicker = $('.datepicker-profile').pickadate({
                                min: new Date(1950,1,1),
                                max: new Date(2011,11,31),
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
                                closeOnSelect: false,
                                hiddenName: true
                            });
                            <?php if($user->birth_date) : ?>
                                var picker = $datepicker.pickadate('picker');
                                picker.set('select', '<?= $user->birth_date ?>', { format: 'yyyy-mm-dd' });
                            <?php endif; ?>
                        </script>
                    </div>
                <?php endif ?>
            </div>
            <div class="col l6 s12">
                <?= $form->field($model, 'vk')->textInput([
                    'value' => $user->vk,
                    'readonly' => $member ? 'true' : false
                ])->label('Профиль VK') ?>
                <?= $form->field($model, 'steam')->textInput([
                    'value' => $user->steam,
                    'readonly' => $member ? 'true' : false
                ])->label('Профиль Steam') ?>
                <?= $form->field($model, 'steamid64')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'visible_steam', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Сделать профиль Steam видимым для всех') ?>
                <?= $form->field($model, 'visible_truckersmp', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox([
                        'label' => null,
                        'disabled' => $user->steam == '' ? 'true' : false
                    ])->error(false)->label('Показать профиль TruckersMP') ?>
                <?php $display = $user->visible_truckersmp == '1' ? 'block' : 'none' ?>
                <?= $form->field($model, 'truckersmp')->textInput([
                        'value' => $user->truckersmp,
                        'style' => 'display: '.$display,
                        'readonly' => 'true'
                    ])->label(false) ?>
                <?= $form->field($model, 'nickname')->textInput([
                    'value' => $user->nickname,
                    'readonly' => $member ? 'true' : false
                ])->label('Ваш игровой псевдоним') ?>
                <?= $form->field($model, 'company')->textInput([
                    'value' => $member ? 'Volvo Trucks' : $user->company,
                    'readonly' => $member ? 'true' : false
                ])->label('Ваша компания') ?>
                <?= $form->field($model, 'has_ets', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Есть <b>Euro Truck Simulator 2</b>') ?>
                <?= $form->field($model, 'has_ats', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->error(false)->label('Есть <b>American Truck Simulator</b>') ?>
            </div>
            <?php if($member): ?>
                <div class="col s12">
                    <p class="grey-text">*Сотрудники ВТК Volvo Trucks ограничены в редактировании некоторых данных профиля. Для их изменения, пожалуйста, обратитесь к одному из администраторов.</p>
                </div>
            <?php endif ?>
        </div>
        <div class="card-action">
            <?=Html::submitButton('Сохранить '.
                Html::tag('i', 'save', ['class' => 'material-icons notranslate right']), [
                'class' => 'btn indigo darken-3 waves-effect waves-light',
                'name' => 'save_profile'
            ]);
            ActiveForm::end(); ?>
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'id' => 'password-form',
        'fieldConfig' => [
            'template' => "<div class=\"input-field col s9\">{label}{input}</div>".
                "<div class=\"col l3 valign-wrapper helper\">{error}</div>",
            'options' => ['class' => 'row'],
            'inputOptions' => ['autocomplete' => 'Off']
        ]
    ]);?>
    <div class="card grey lighten-4">
        <div class="card-content">
            <span class="card-title">Изменить пароль</span>
            <?= $form->field($model, 'password')->passwordInput([
                'required' => 'required'
            ])->label('Старый пароль*') ?>
            <?= $form->field($model, 'password_new')->passwordInput([
                'required' => 'required'
            ])->label('Новый пароль*') ?>
            <?= $form->field($model, 'password_new_2')->passwordInput([
                'required' => 'required'
            ])->label('Повторите новый пароль*') ?>
        </div>
        <div class="card-action">
            <?=Html::submitButton('Изменить пароль '.
                Html::tag('i', 'save', ['class' => 'material-icons notranslate right']), [
                'class' => 'btn indigo darken-3 waves-effect waves-light',
                'name' => 'save_profile_password'
            ])?>
        </div>
    </div>
    <?php if($model->hasErrors()) : ?>
        <script>
            <?php foreach ($model->errors as $error): ?>
            Materialize.toast('<?= $error[0] ?>', 6000);
            <?php endforeach; ?>
        </script>
    <?php endif ?>
    <?php ActiveForm::end(); ?>
</div>