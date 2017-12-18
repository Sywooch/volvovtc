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

    require_once 'contact.php';

    if(\app\models\User::isAdmin()) require_once 'admin_fixed_btn.php'; ?>

</div>