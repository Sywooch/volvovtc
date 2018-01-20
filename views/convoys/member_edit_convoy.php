<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Yii::$app->controller->action->id == 'add' ? 'Добавить конвой' : 'Редактировать конвой' ;
$this->title .= $model->game == 'ets' ? ' по ETS2' : ' по ATS';
$this->title .= ' - Volvo Trucks';
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/admin.js?t='.time(),  ['position' => yii\web\View::POS_HEAD, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/cities.js?t='.time(),  ['position' => yii\web\View::POS_END]);
$this->registerJsFile(Yii::$app->request->baseUrl.'/assets/js/select2.min.js',  ['position' => yii\web\View::POS_HEAD, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2.min.css');
$this->registerCssFile(Yii::$app->request->baseUrl.'/assets/css/select2-custom.css?t='.time());
$this->registerJsFile(Yii::$app->request->baseUrl.'/lib/ck-editor/ckeditor.js?t='.time(),  ['position' => yii\web\View::POS_HEAD]);
?>

<div class="container">
	<h5 class="light"><?= str_replace(' - Volvo Trucks', '', $this->title) ?></h5>
	<div class="row">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<div class="col m6 s12">
			<div class="card-panel grey lighten-4">
				<h5 class="light">Основная информация</h5>
				<div class="picture-full">
					<label>Оригинальная карта маршрута (макс. 15 Мб)</label>
					<div class="file-field">
						<div class="btn indigo darken-3 waves-effect waves-light">
							<span>Загрузить изображение</span>
							<?= $form->field($model, 'picture_full')->fileInput([
								'class' => 'validate-img-size',
								'data-maxsize' => '15000000',
								'data-alert' => 'Максимальный размер файла 15Мб',
							]) ?>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path" type="text" readonly="readonly" value="<?= $model->picture_full ?>">
						</div>
					</div>
				</div>
				<div class="picture-small" style="display: none">
					<label>Уменьшенная карта маршрута (макс. 5 Мб)</label>
					<div class="file-field">
						<div class="btn indigo darken-3 waves-effect waves-light">
							<span>Загрузить изображение</span>
							<?= $form->field($model, 'picture_small')->fileInput([
								'class' => 'validate-img-size',
								'data-maxsize' => '5000000',
								'data-alert' => 'Максимальный размер файла 5Мб',
							]) ?>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path" type="text" readonly="readonly">
						</div>
					</div>
				</div>
				<div class="center">
					<?php if($model->game == 'ets') : ?>
						<?= $form->field($model, 'dlc[Going East!]', [
							'template' => '{input}{label}',
							'options' => [
								'tag' => false
							]
						])->checkbox(['label' => null])->error(false)->label('Going East!') ?>
						<?= $form->field($model, 'dlc[Scandinavia]', [
							'template' => '{input}{label}',
							'options' => [
								'tag' => false
							]
						])->checkbox(['label' => null])->error(false)->label('Scandinavia') ?>
						<?= $form->field($model, 'dlc[Vive La France!]', [
							'template' => '{input}{label}',
							'options' => [
								'tag' => false
							]
						])->checkbox(['label' => null])->error(false)->label('Vive La France!') ?>
						<?= $form->field($model, 'dlc[Italia]', [
							'template' => '{input}{label}',
							'options' => [
								'tag' => false
							]
						])->checkbox(['label' => null])->error(false)->label('Italia') ?>
					<?php else : ?>
						<?= $form->field($model, 'dlc[New Mexico]', [
							'template' => '{input}{label}',
							'options' => [
								'tag' => false
							]
						])->checkbox(['label' => null])->error(false)->label('New Mexico') ?>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div class="col m6 s12">
			<div class="card-panel grey lighten-4">
				<h5 class="light">Превью карты маршрута</h5>
				<?php if($model->picture_small): ?>
					<img src="<?=Yii::$app->request->baseUrl?>/images/convoys/<?= $model->picture_small ?>?t=<?= time() ?>" class="responsive-img z-depth-2" id="preview">
					<?= $form->field($model, 'map_remove', [
						'template' => '{input}{label}',
						'options' => ['tag' => false]])->checkbox(['label' => null])->error(false)->label('Удалить карту маршрута') ?>
				<?php else: ?>
					<img src="<?=Yii::$app->request->baseUrl?>/assets/img/no_route.jpg" class="responsive-img z-depth-2" id="preview">
				<?php endif ?>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col l6 s12">
			<div class="card-panel grey lighten-4">
				<h5 class="light">Сборы</h5>
				<?= $form->field($model, 'date')
					->input('date', [
						'class' => 'datepicker-member-convoy',
						'data-value' => $model->date
					])
					->error(false) ?>
				<?= $form->field($model, 'meeting_time')->input('time', ['class' => 'timepicker'])->error(false) ?>
				<?= $form->field($model, 'departure_time')->input('time', ['class' => 'timepicker'])->error(false) ?>
				<?= $form->field($model, 'server')->dropdownList($servers)->error(false) ?>
				<div class="input-field">
					<?= $form->field($model, 'communications')->textInput(['readonly' => 'readonly'])->error(false) ?>
				</div>
			</div>
		</div>
		<div class="col l6 s12">
			<div class="card-panel grey lighten-4">
				<h5 class="light">Маршрут</h5>
				<?php $class = 'autocomplete';
					if($model->game == 'ats') $class .= '-ats'; ?>
				<div class="input-field">
					<?= $form->field($model, 'start_city')->textInput(['class' => $class.'-city', 'autocomplete' => 'off'])->error(false) ?>
				</div>
				<div class="input-field">
					<?= $form->field($model, 'start_company')->textInput(['class' => $class.'-company', 'autocomplete' => 'off'])->error(false) ?>
				</div>
				<div class="input-field">
					<?= $form->field($model, 'finish_city')->textInput(['class' => $class.'-city', 'autocomplete' => 'off'])->error(false) ?>
				</div>
				<div class="input-field">
					<?= $form->field($model, 'finish_company')->textInput(['class' => $class.'-company', 'autocomplete' => 'off'])->error(false) ?>
				</div>
				<div class="input-field">
					<?= $form->field($model, 'rest')->textInput()->error(false) ?>
				</div>
				<div class="input-field">
					<?= $form->field($model, 'length')->textInput()->error(false) ?>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="col l6 s12">
			<div class="card-panel grey lighten-4">
				<h5 class="light" style="padding-bottom: 10px">Дополнительная информация</h5>
				<div class="input-field">
					<?= $form->field($model, 'truck_var', ['template' => '{input}{label}'])
						->dropdownList(\app\models\Convoys::getVariationsByGame($model->game))
						->error(false) ?>
				</div>
				<?php foreach($model->trailer as $key => $trailer) : ?>
				<div class="row inner">
					<div class="col l11 s10" style="padding-bottom: 20px;">
						<?php if($key == 0) : ?><label class="control-label">Прицепы</label><?php endif ?>
						<?= $form->field($model, 'trailer['.$key.']')
							->dropdownList($trailers, [
								'id' => 'trailer-select-'.$key,
								'class' => 'browser-default trailers-select',
								'data-target' => 'trailers'])
							->error(false)
							->label(false) ?>
						<script>
							$('#trailer-select-'+<?=$key?>).select2();
						</script>
					</div>
					<?php if($key == 0) : ?>
						<div class="col l1 s2 center add-btn-container" style="line-height: 66px;">
							<button class="tooltipped indigo-text add-trailer" type="button" data-position="bottom" data-tooltip="Добавить прицеп">
								<i class="material-icons notranslate small">add</i>
							</button>
						</div>
					<?php else : ?>
						<div class="col l1 s2 center" style="line-height: 44px;">
							<button class="tooltipped red-text remove-trailer" data-position="bottom" data-tooltip="Убрать прицеп">
								<i class="material-icons notranslate small">clear</i>
							</button>
						</div>
					<?php endif ?>
					</div>
					<?php endforeach ?>
					<label>Дополнительное изображение (если необходимо) (макс. 15 Мб)</label>
					<div class="file-field">
						<div class="btn indigo darken-3 waves-effect waves-light">
							<i class="material-icons notranslate left">add</i>
							<span>Загрузить</span>
							<?= $form->field($model, 'extra_picture')->fileInput()->label(false)->error(false) ?>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path" type="text" value="<?= $model->extra_picture ?>" readonly="readonly">
						</div>
					</div>
				</div>
			</div>
			<div class="col l6 s12">
				<div class="card-panel grey lighten-4">
					<h5 class="light">Превью изображения прицепа</h5>
					<div id="trailer-info" class="row">
						<?php switch(count($model->trailer)){
							case '4' : $cols = 6;break;
							case '3' : $cols = 4;break;
							case '2' : $cols = 6;break;
							case '1' :
							default: $cols = 12;break;
						} ?>
						<?php if(Yii::$app->controller->action->id == 'edit'){
							foreach($model->trailer as $key => $trailer) : ?>
								<div class="trailer-preview col s<?=$cols?>">
									<img src="<?= Yii::$app->request->baseUrl . '/images/' . $trailers_data[$key] ?>" class="responsive-img z-depth-2 materialboxed" id="trailer-image-<?= $key ?>">
								</div>
							<?php endforeach;
						}else{ ?>
							<div class="trailer-preview col s<?=$cols?>">
								<img src="<?= Yii::$app->request->baseUrl . '/images/trailers/default.jpg' ?>" class="responsive-img z-depth-2 materialboxed" id="trailer-image-0">
							</div>
						<?php } ?>
						<div class="clearfix"></div>
					</div>
					<?php if($model->extra_picture) : ?>
						<img src="<?= Yii::$app->request->baseUrl . '/images/convoys/' . $model->extra_picture ?>" class="responsive-img z-depth-2">
						<a href="<?= Url::to(['convoys/deleteextrapicture', 'id' => $_GET['id']]) ?>" class="btn indigo darken-3 waves-effect waves-light" onclick="return confirm('Удалить дополнительное изображение?')">
							<i class="material-icons notranslate left">clear</i>Удалить
						</a>
					<?php endif ?>
				</div>
			</div>
			<div class="col s12">
				<div class="card-panel grey lighten-4">
					<h5 class="light">Описание</h5>
					<div class="input-field file-field">
						<?= $form->field($model, 'add_info')->textarea(['class' => 'materialize-textarea', 'id' => 'add_info'])->label(false) ?>
					</div>
				</div>
			</div>
			<div class="col s12">
				<div class="card-panel grey lighten-4">
					<h5 class="light">
						<i class="material-icons notranslate small left">info</i>
						После сохранения, конвой будет отправлен на модерацию и
						появится в разделе <a href="<?= Url::to(['convoys/index']) ?>">Конвои</a> после одобрения одним из администраторов.
					</h5>
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
	<script type="text/javascript">
		CKEDITOR.replace('add_info');
	</script>