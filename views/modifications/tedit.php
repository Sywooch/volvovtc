<?php

use yii\helpers\Url;

$this->title = 'TEDIT для ETS2 и ATS - Volvo Trucks';
$this->registerMetaTag([
	'name' => 'description',
	'content' => 'Tedit для Euro Truck Simulator 2 Multiplayer и American Truck Simulator Multiplayer. Tedit для TruckersMP.'
]);
$this->registerMetaTag([
	'name' => 'keywords',
	'content' => 'tedit, ets2, ats, truckersmp, tedit для ets2mp, tedit для atsmp, как найти прицеп на конвой, как взять груз на конвой'
]);
?>

<div class="parallax-container parallax-shadow hide-on-small-only" style="height: 400px;">
    <div class="container">
        <h4 class="parallax-title light white-text text-shadow">TEDIT - Личный прицеп</h4>
    </div>
    <div class="parallax"><img src="<?=Yii::$app->request->baseUrl?>/assets/img/mods/mods-main.jpg"></div>
</div>

<div class="container">
    <div class="card horizontal grey lighten-4">
        <div class="card-image tedit-img hide-on-med-and-down" style="background-image: url(<?=Yii::$app->request->baseUrl?>/assets/img/mods/tedit.png)"></div>
        <div class="card-stacked">
            <div class="card-content">
				<p><i class="material-icons notranslate left orange-text">warning</i>Для корректной работы программы нужно открыть <b>config.cfg</b> через текстовый редактор и
					в параметре <b>g_save_format</b> изменить значение <b>0</b> на <b>2</b>.</p>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">ondemand_video</i>Euro Truck Simulator 2</div>
                        <div class="collapsible-body">
                            <div class="video-container">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/XOYwF48E_PU?rel=0" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header grey lighten-4"><i class="material-icons notranslate">ondemand_video</i>American Truck Simulator</div>
                        <div class="collapsible-body">
                            <div class="video-container">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/TwS63ASk36E?rel=0" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
			<div class="card-action">
				<a class="btn indigo darken-3 waves-effect waves-light" href="<?= Yii::$app->request->baseUrl ?>/tedit_v6.11.2.rar" target="_blank">
					<i class="material-icons notranslate left">file_download</i>
					Скачать TEDIT v6.11.2
				</a>
				<a href="http://truck-sim.club/topic/21801-svoi-pritcep-tedit-v6112-reliz-i-obschee-obsuzhdenie/?p=371683" class="right btn-flat" target="_blank">
					Всегда свежая версия
				</a>
			</div>
        </div>
    </div>
</div>

<div class="fixed-action-btn">
	<a class="btn-floating btn-large green tooltipped waves-effect waves-light" href="https://generator.volvovtc.com/" target="_blank"
	   data-tooltip="Сгенерировать мод на прицеп" data-position="left">
		<i class="material-icons notranslate">build</i>
	</a>
</div>