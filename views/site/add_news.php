<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить новость - Volvo Trucks';
$this->registerJsFile(Yii::$app->request->baseUrl.'/lib/ck-editor/ckeditor.js?t='.time(),  ['position' => yii\web\View::POS_HEAD]);
?>

<div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col l12 s12">
            <div class="card-panel grey lighten-4">
                <h5>Добавление новости</h5>
                <label>Изображения новости (макс. 10)</label>
                <div class="images-upload row">
                    <?php if($pics = unserialize($model->picture)) : ?>
                        <?php foreach($pics as $pic) : ?>
                            <div class="col l3 s6">
                                <label class="card-panel delete-item upload-item" style="background-image: url(<?= Yii::$app->request->baseUrl ?>/images/news/<?= $pic ?>?t=<?= time() ?>">
                                    <i class="material-icons medium red-text">clear</i>
                                    <input type="hidden" name="picture[]" value="<?= $pic ?>">
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif ?>
                    <?php if(count($pics) < 10): ?>
                        <div class="col l3 s6">
                            <label class="card-panel upload-item">
                                <i class="material-icons medium black-text">add</i>
                                <input type="file" style="display:none;">
                            </label>
                        </div>
                    <?php endif ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'title')->textInput()->error(false) ?>
                </div>
                <div class="input-field">
                    <?= $form->field($model, 'subtitle')->textInput() ?>
                </div>
                <label>Текст новости</label>
                <?= $form->field($model, 'text')->textarea([
                    'id' => 'article',
                    'rows' => '10',
                    'style' => 'resize: vertical;height: 200px;'
                ])->label(false) ?>
                <div class="input-field">
                    <?= $form->field($model, 'visible', ['template' => '<div>{input}{label}</div>'])
                        ->checkbox(['label' => null])->label('Сделать новость видимой') ?>
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
<script type="text/javascript">
    CKEDITOR.replace('article');
</script>
<?php if($errors) : ?>
    <script>
        Materialize.toast(<?= $errors[0] ?>, 6000);
    </script>
<?php endif ?>