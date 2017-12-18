<div class="row">
    <?php foreach ($mods as $key => $mod):
        $trailer_data = \app\models\Mods::getTrailerData($mod);
        $class = $mod->visible == '1' ? 'grey' : 'yellow';

        require 'mod/index.php';

        require 'clearfix.php';

    endforeach; ?>
</div>