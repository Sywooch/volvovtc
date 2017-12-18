<?php use yii\helpers\Url; ?>

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