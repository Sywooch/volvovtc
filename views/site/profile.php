<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<div class="container">
    <?php if($edit){
        $this->title = 'Редактирование профиля - Volvo Trucks';
        $form = ActiveForm::begin([
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
                    <i class="material-icons medium">file_upload</i>
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
                    <i class="material-icons medium">file_upload</i>
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
                    <?= $form->field($model, 'birth_date')->input('date', [
                        'class' => 'datepicker-profile',
                        'readonly' => $member ? 'true' : false
                    ])->label('Дата рождения') ?>
                    <script>
                        $datepicker = $('.datepicker-profile').pickadate({
                            min: new Date(1950,1,1),
                            max: true,
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
                        <?php if($user->birth_date) : ?>
                            var picker = $datepicker.pickadate('picker');
                            picker.set('select', '<?= $user->birth_date ?>', { format: 'yyyy-mm-dd' });
                        <?php endif; ?>
                    </script>
                <?php endif ?>
            </div>
            <div class="col l6 s12">
                <?= $form->field($model, 'vk')->textInput([
                    'value' => $user->vk,
                    'readonly' => $member ? 'true' : false
                ])->label('Профиль VK') ?>
                <?= $form->field($model, 'steam')->textInput([
                    'value' => $user->steam,
                    'readonly' => $member ? 'true' : 'false'
                ])->label('Профиль Steam') ?>
                <?= $form->field($model, 'steamid64')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'visible_truckersmp', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox([
                        'label' => null,
                        'disabled' => $user->steam == '' || $member? 'true' : false
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
                Html::tag('i', 'save', ['class' => 'material-icons right']), [
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
                Html::tag('i', 'save', ['class' => 'material-icons right']), [
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
    <?php ActiveForm::end();
    }else{
        $this->title = 'Профиль - Volvo Trucks'; ?>
        <div class="card grey lighten-4">
            <div class="card-image no-img" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/bg/<?=$user->bg_image?>)">
                <div class="profile-img z-depth-3 <?php if(\app\models\User::isOnline($user)) : ?>online<?php endif ?>" style="background-image: url(<?=Yii::$app->request->baseUrl?>/images/users/<?=$user->picture?>)"></div>
                <?php if($user->nickname) : ?>
                    <span class="card-title text-shadow">
                        <?php if($user->company): ?>
                            [<?=$user->company ?>]
                        <?php endif ?>
                        <?=htmlentities($user->nickname) ?>
                    </span>
                <?php else: ?>
                    <span class="card-title text-shadow"><?=$user->username ?></span>
                <?php endif; ?>
            </div>
            <div class="card-content row profile-content">
                <div class="col l6 s12">
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>Имя:</p></div>
                        <div class="col l7 s7 profile-info"><p><?=$user->first_name?></p></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>Фамилия:</p></div>
                        <div class="col l7 s7 profile-info"><p><?=$user->last_name?></p></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>Возраст:</p></div>
                        <div class="col l7 s7 profile-info"><p><?= $user->age ?></p></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align truncate"><p>Дата рождения:</p></div>
                        <div class="col l7 s7 profile-info truncate"><p><?= \app\controllers\SiteController::getRuDate($user->birth_date) ?></p></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>Страна:</p></div>
                        <div class="col l7 s7 profile-info"><p><?=$user->country?></p></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>Город:</p></div>
                        <div class="col l7 s7 profile-info"><p><?=$user->city?></p></div>
                    </div>
                </div>
                <div class="col l6 s12">
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>E-Mail:</p></div>
                        <div class="col l7 s7 profile-info">
                            <p><?=$user->visible_email == '1' ? '<a href="mailto:'.$user->email.'">'.$user->email.'</a>' : '<i>E-Mail скрыт</i>' ?></p>
                        </div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align truncate"><p>Состоит в компании:</p></div>
                        <div class="col l7 s7 profile-info truncate"><p><?=$user->company?></p></div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>Наличие игр:</p></div>
                        <div class="col l7 s7 profile-info">
                            <p><?php
                                if($user->has_ets == '0' && $user->has_ats == '0') echo 'Нет игр';
                                else if($user->has_ets == '0' && $user->has_ats == '1') echo 'ATS';
                                else if($user->has_ets == '1' && $user->has_ats == '0') echo 'ETS2';
                                else if($user->has_ets == '1' && $user->has_ats == '1') echo 'ETS2 и ATS';
                                ?></p>
                        </div>
                    </div>
                    <div class="col l12 s12">
                        <div class="col l5 s5 right-align"><p>Профили:</p></div>
                        <div class="col l7 s7 profile-info">
                            <div class="profile-links">
                                <ul class="socials links">
                                    <?php if($user->vk){ ?>
                                        <li class="vk z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?=$user->vk?>"></a></li>
                                    <?php }
                                    if($user->steam){ ?>
                                        <li class="steam z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?=$user->steam?>"></a></li>
                                    <?php }
                                    if($user->truckersmp && ($user->visible_truckersmp == '1' || \app\models\User::isAdmin())){ ?>
                                        <li class="truckers-mp z-depth-3"><a class="waves-effect waves-light" target="_blank" href="<?=$user->truckersmp?>"></a></li>
                                    <?php }
                                    if(!$user->truckersmp && !$user->steam && !$user->vk){?>
                                        <li class="no-bg"><p>Нет указаных профилей</p></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                if(!Yii::$app->user->isGuest && $user->id === Yii::$app->user->identity->id){?>
                    <div class="card-action">
                        <a href="<?=Url::to(['site/profile', 'action' => 'edit'])?>" class="indigo-text text-darken-3">Редактировать профиль</a>
                        <a href="<?=Url::to(['site/logout'])?>" class="indigo-text text-darken-3">Выйти</a>
                    </div>
                <?php } ?>
        </div>
    <?php } ?>
</div>