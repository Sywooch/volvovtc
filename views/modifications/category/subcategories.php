<?php

use yii\helpers\Url;

?>

<div class="row subcategories">
    <?php foreach($all_subcategories as $key => $subcat) :
        if($subcategory->name == $subcat->name) $class = 'disabled';
        else $class = ''; ?>
        <div class="col <?php if($key != 8): ?>l3 m4<?php endif ?> s12">
            <a href="<?= Url::to([
                'modifications/category',
                'game' => $category->game,
                'category' => $category->name,
                'subcategory' => $subcat->name
            ]) ?>" class="btn-flat <?= $class ?> waves-effect waves-light"><?= $subcat->title ?></a>
        </div>
    <?php endforeach; ?>
</div>