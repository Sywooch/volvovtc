<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Подать заявление на отпуск - Volvo Trucks';
?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <div class="input-field">
                    <?= $form->field($model, 'to_date')->input('date', ['class' => 'datepicker-add-claim'])->error(false) ?>
                    <script>
                        $datepicker = $('.datepicker-add-claim').pickadate({
                            min: true,
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
                    </script>
                </div>
                <?= $form->field($model, 'vacation_undefined', ['template' => '<div>{input}{label}</div>'])
                    ->checkbox(['label' => null])->label('Неопределенный срок') ?>
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
<?php if($model->hasErrors()) :
    //Kint::dump($model->errors)?>
    <script>
        <?php foreach ($model->errors as $error): ?>
        Materialize.toast('<?= $error[0] ?>', 6000);
        <?php endforeach; ?>
    </script>
<?php endif ?>