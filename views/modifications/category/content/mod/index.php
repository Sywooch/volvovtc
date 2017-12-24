<div class="col l6 s12">
    <div class="card <?= $class ?> lighten-4 hoverable">

        <div class="card-image mod-img">
            <img class="materialboxed" width="100%" src="<?=Yii::$app->request->baseUrl?>/images/<?= $trailer_data['image'] ?>">
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
            <a href="<?= Yii::$app->request->baseUrl.'/mods_mp/'.$mod->game.'/'.$mod->file_name
                ?>" class="waves-effect">Скачать
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

            <?php if(\app\models\User::isAdmin()){
                require 'admin_actions.php';
            } ?>

        </div>

    </div>
</div>