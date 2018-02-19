<?php

$this->title = 'Ошибка - Страница не найдена';

if($meta){
	foreach($meta as $item){
		$this->registerMetaTag($item);
	}
}

?>
<div class="container">

    <div class="card grey lighten-3">
        <div class="card-image no-img" style="background-image: url(<?= Yii::$app->request->baseUrl ?>/web/assets/img/404.jpg"></div>
        <div class="card-content">
            <h3>Ошибка 404 - Страница не найдена</h3>
			<?php if(Yii::$app->user->isGuest) : ?>
				<?php \yii\helpers\Url::remember() ?>
			    <p><a href="<?= \yii\helpers\Url::to(['site/login']) ?>">Войдите</a> на сайт и попробуйте еще раз.</p>
			<?php endif ?>
        </div>
    </div>

</div>