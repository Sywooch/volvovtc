<?php

use yii\helpers\Url;

$this->title = $subcategory->cat_title . ' - ' . $subcategory->title . ' - Volvo Trucks'; ?>

<div class="parallax-container parallax-shadow hide-on-small-only" style="height: 400px;">
	<div class="container">
		<h4 class="parallax-title light white-text text-shadow"><?= $subcategory->cat_title ?></h4>
	</div>
	<div class="parallax"><img src="<?=Yii::$app->request->baseUrl?>/images/mods/categories/<?=$subcategory->cat_image?>"></div>
</div>

<div class="container">

	<h4 class="light center hide-on-med-and-up"><?= $subcategory->cat_title ?></h4>

	<?php if(count($all_subcategories) > 1): ?>
		<div class="row subcategories">
			<?php foreach($all_subcategories as $key => $subcat) :
				if($subcategory->name == $subcat->name) $class = 'disabled';
				else $class = ''; ?>
				<div class="col <?php if($key != 8): ?>l3 m4<?php endif ?> s12">
					<a href="<?= Url::to([
						'modifications/category',
						'game' => $subcategory->for_ets == '1' ? 'ets' : 'ats',
						'category' => $subcategory->cat_name,
						'subcategory' => $subcat->name
					]) ?>" class="btn-flat <?= $class ?> waves-effect waves-light"><?= $subcat->title ?></a>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif ?>

	<?php if($mods): ?>
		<div class="row">
			<?php foreach ($mods as $key => $mod):
				$class = $mod->visible == '1' ? 'grey' : 'yellow'; ?>

				<div class="col l6 s12">
					<div class="card <?= $class ?> lighten-4 hoverable">

						<div class="card-image mod-img">
							<img class="materialboxed" width="100%"
								 src="<?=Yii::$app->request->baseUrl?>/images/<?= $mod->trailer ? 'trailers/'.$mod->tr_image : 'mods/'.$mod->picture ?>">
						</div>

						<div class="card-content mod-info">
							<h6 class="fs17 mod-title"><?= $mod->title ?></h6>
							<?php if($mod->description) : ?>
								<div class="mod-description">
									<span><?= $mod->description ?></span>
								</div>
							<?php endif ?>
							<?php if($mod->warning) : ?>
								<div class="mod-warning">
									<span>(<?= $mod->warning ?>)</span>
								</div>
							<?php endif ?>
						</div>

						<div class="card-action mod-links">
							<a href="<?= \app\models\Mods::getModsPath($mod->game) . $mod->file_name ?>" class="waves-effect">Скачать
								<i class="material-icons notranslate left">get_app</i>
							</a>
							<?php if($mod->yandex_link) : ?>
								<a href="<?= $mod->yandex_link ?>" class="waves-effect">Яндекс.Диск</a>
							<?php endif ?>
							<?php if($mod->gdrive_link) : ?>
								<a href="<?= $mod->gdrive_link ?>" class="waves-effect">Google Drive</a>
							<?php endif ?>
							<?php if($mod->mega_link) : ?>
								<a href="<?= $mod->mega_link ?>" class="waves-effect">MEGA</a>
							<?php endif ?>

							<?php if(\app\models\User::isAdmin()) : ?>
								<a class='action-dropdown-button right' data-id="<?= $mod->id ?>"><i class="material-icons notranslate">more_vert</i></a>

								<ul id="action-dropdown-<?= $mod->id ?>" class='action-dropdown card-panel grey lighten-4'>
									<li class="clearfix">
										<a href="<?= Url::to(['modifications/edit', 'id' => $mod->id]) ?>" class="indigo-text">
											<i class="material-icons notranslate left">edit</i>Редактировать
										</a>
									</li>
									<li class="clearfix">
										<a onclick='return confirm("Удалить?")' href="<?= Url::to(['modifications/remove', 'id' => $mod->id]) ?>" class="indigo-text">
											<i class="material-icons notranslate left">delete</i>Удалить
										</a>
									</li>
									<li class="clearfix">
										<a href="<?= Url::to([$mod->visible == '1' ? 'modifications/hide' : 'modifications/show', 'id' => $mod->id]) ?>" class="indigo-text">
											<i class="material-icons notranslate left"><?= $mod->visible === 1 ? 'visibility' : 'visibility_off' ?></i>Спрятать/Показать
										</a>
									</li>
									<?php if(count($mods) > 1) { ?>
										<li class="divider"></li>
										<li class="clearfix">
											<a href="<?= Url::to(['modifications/sort', 'id' => $mod->id, 'dir' => 'up']) ?>" class="indigo-text">
												<i class="material-icons notranslate left">keyboard_arrow_up</i>Переместить выше
											</a>
										</li>
										<li class="clearfix">
											<a href="<?= Url::to(['modifications/sort', 'id' => $mod->id, 'dir' => 'down']) ?>" class="indigo-text">
												<i class="material-icons notranslate left">keyboard_arrow_down</i>Переместить ниже
											</a>
										</li>
									<?php } ?>
								</ul>
							<?php endif ?>
						</div>

					</div>
				</div>

				<?php if($key % 2 != 0) : ?>
					<div class="clearfix"></div>
				<?php endif ?>

			<?php endforeach; ?>
		</div>
	<?php else : ?>
		<h5 class="light">Пока что нет модов в этой категории =(</h5>
	<?php endif ?>

	<p class="grey-text light">Нужна модификация для мультиплеера?
		<a href="https://vk.com/im?sel=-105444090" target="_blank" style="text-decoration: underline;">Пиши нам!</a>
	</p>

	<div class="fixed-action-btn">
		<a class="btn-floating btn-large green tooltipped waves-effect waves-light" href="https://generator.volvovtc.com/" target="_blank"
		   data-tooltip="Сгенерировать мод на прицеп" data-position="left">
			<i class="material-icons notranslate">build</i>
		</a>
	</div>

	<?php if(\app\models\User::isAdmin()) : ?>
		<div class="fixed-action-btn fixed-action-btn_second">
			<a href="<?=Url::to(['modifications/add'])?>" class="btn-floating btn-large waves-effect waves-light red">
				<i class="material-icons notranslate">add</i>
			</a>
		</div>
	<?php endif ?>

</div>