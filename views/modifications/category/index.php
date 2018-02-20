<?php

$this->title = $category->title . ' - '.$subcategory->title . ' - Volvo Trucks';

require_once 'parallax.php' ?>

<div class="container">

    <?php require_once 'cat_title_mobile.php';

    if(count($all_subcategories) > 1) require_once 'subcategories.php';

    if($mods) {
        require_once 'content/index.php';
    } else {
        require_once 'empty_subcat.php';
    }

    require_once 'contact.php'; ?>

	<div class="fixed-action-btn">
		<a class="btn-floating btn-large green tooltipped waves-effect waves-light" href="https://generator.volvovtc.com/" target="_blank"
		   data-tooltip="Сгенерировать мод на прицеп" data-position="left">
			<i class="material-icons notranslate">build</i>
		</a>
	</div>

    <?php if(\app\models\User::isAdmin()) require_once 'admin_fixed_btn.php'; ?>

</div>