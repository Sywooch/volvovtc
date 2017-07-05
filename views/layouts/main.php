<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=Yii::$app->request->baseUrl?>/favicon.ico" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php if(Yii::$app->controller->action->id === 'news' || Yii::$app->controller->action->id === 'variations') : ?>
        <link href="<?=Yii::$app->request->baseUrl?>/assets/css/fotorama.css" rel="stylesheet">
    <?php endif ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-99570317-1', 'auto');
        ga('send', 'pageview');
    </script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrapper">
    <div class="mobile-navbar">
        <ul id="slide-out" class="hide-on-large-only side-nav">
            <li>
                <?php $bg = Yii::$app->user->isGuest ? 'default.jpg' : Yii::$app->user->identity->bg_image ?>
                <div class="userView" style="background-image: url(<?= Yii::$app->request->baseUrl.'/images/users/bg/'. $bg . '?t='.time()?>); height: 160px;">
                    <?php if(!Yii::$app->user->isGuest) : ?>
                    <a href="<?=Url::to(['site/profile'])?>"><img class="circle" src="<?=Yii::$app->request->baseUrl.'/images/users/'.Yii::$app->user->identity->picture.'?t='.time()?>"></a>
                    <a href="<?=Url::to(['site/profile'])?>">
                        <span class="white-text text-shadow name"><?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->last_name?></span>
                    </a>
                    <a href="<?=Url::to(['site/profile'])?>">
                        <span class="white-text text-shadow email">
                            <?php if(Yii::$app->user->identity->company != '') : ?>
                                [<?=Yii::$app->user->identity->company?>]
                            <?php endif ?>
                            <?=Yii::$app->user->identity->nickname?>
                        </span>
                    </a>
                    <?php endif ?>
                </div>
            </li>
            <li<?php if(Yii::$app->controller->action->id === 'index'){?> class="active"<?php } ?>><a href="<?=Yii::$app->request->baseUrl?>/">
                    <i class="material-icons">home</i>О НАС</a>
            </li>
            <li<?php if(Yii::$app->controller->action->id === 'rules'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/rules'])?>">
                    <i class="material-icons">error</i>ПРАВИЛА</a>
            </li>
            <li<?php if(Yii::$app->controller->action->id === 'news'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/news'])?>">
                    <i class="material-icons">view_quilt</i>НОВОСТИ</a>
            </li>
            <li<?php if(Yii::$app->controller->action->id === 'convoys'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/convoys'])?>">
                    <i class="material-icons">local_shipping</i>КОНВОИ</a>
            </li>
            <?php if(\app\models\VtcMembers::find()->where(['user_id' => Yii::$app->user->id])->one() == false): ?>
                <li<?php if(Yii::$app->controller->action->id === 'recruit'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/recruit'])?>">
                        <i class="material-icons">contacts</i>ВСТУПИТЬ</a>
                </li>
            <?php endif ?>
            <li<?php if(Yii::$app->controller->action->id === 'members'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/members'])?>">
                    <i class="material-icons">view_module</i>ВОДИТЕЛИ</a>
            </li>
            <li<?php if(Yii::$app->controller->action->id === 'claims'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/claims'])?>">
                    <i class="material-icons">receipt</i>ЗАЯВЛЕНИЯ</a>
            </li>
            <li<?php if(Yii::$app->controller->action->id === 'modifications'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/modifications'])?>">
                    <i class="material-icons">settings</i>МОДЫ</a>
            </li>
            <?php if(Yii::$app->user->isGuest) : ?>
                <li<?php if(Yii::$app->controller->action->id === 'login'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/login'])?>">
                        <i class="material-icons">exit_to_app</i>ВОЙТИ</a>
                </li>
            <?php else : ?>
                <li<?php if(Yii::$app->controller->action->id === 'profile'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/profile'])?>">
                        <i class="material-icons">person</i>ПРОФИЛЬ</a>
                </li>
                <li><a href="<?=Url::to(['site/logout'])?>"><i class="material-icons">exit_to_app</i>ВЫЙТИ</a></li>
            <?php endif ?>
        </ul>
    </div>
    <div class="navbar-fixed">
        <nav class="white">
            <div class="nav-wrapper">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                <a href="<?=Yii::$app->request->baseUrl?>/" class="brand-logo"><img src="<?=Yii::$app->request->baseUrl?>/assets/img/volvo-sign.png" alt="VOLVO TRUCKS"></a>
                <ul id="nav-mobile" class="hide-on-med-and-down right">
                    <li<?php if(Yii::$app->controller->action->id === 'index'){?> class="active"<?php } ?>><a href="<?=Yii::$app->request->baseUrl?>/">О НАС</a></li>
                    <li<?php if(Yii::$app->controller->action->id === 'rules'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/rules'])?>">ПРАВИЛА</a></li>
                    <li<?php if(Yii::$app->controller->action->id === 'news'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/news'])?>">НОВОСТИ</a></li>
                    <li<?php if(Yii::$app->controller->action->id === 'convoys'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/convoys'])?>">КОНВОИ</a></li>
                    <?php if(\app\models\VtcMembers::find()->where(['user_id' => Yii::$app->user->id])->one() == false): ?>
                        <li<?php if(Yii::$app->controller->action->id === 'recruit'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/recruit'])?>">ВСТУПИТЬ</a></li>
                    <?php endif ?>
                    <li<?php if(Yii::$app->controller->action->id === 'modifications'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/modifications'])?>">МОДЫ</a></li>
                    <?php if(\app\models\User::isAdmin()) : ?>
                        <li id="manage-btn">
                            <a href="<?=Url::to(['site/members\', \'action\' => \'stats'])?>">УПРАВЛЕНИЕ</a>
                            <ul id="manage-dropdown" class="z-depth-2">
                                <li><a href="<?=Url::to(['site/members'])?>"><i class="material-icons left">supervisor_account</i>СОТРУДНИКИ</a></li>
                                <li><a href="<?=Url::to(['site/members', 'action' => 'stats'])?>"><i class="material-icons left">insert_chart</i>СТАТИСТИКА</a></li>
                                <li><a href="<?=Url::to(['site/users'])?>"><i class="material-icons left">people</i>ПОЛЬЗОВАТЕЛИ САЙТА</a></li>
                                <li><a href="<?=Url::to(['site/trailers'])?>"><i class="material-icons left">local_shipping</i>УПРАВЛЕНИЕ ПРИЦЕПАМИ</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li<?php if(Yii::$app->controller->action->id === 'members'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/members'])?>">ВОДИТЕЛИ</a></li>
                    <?php endif ?>
                    <li<?php if(Yii::$app->controller->action->id === 'claims'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/claims'])?>">ЗАЯВЛЕНИЯ</a></li>
                    <?php if(Yii::$app->user->isGuest) : ?>
                    <li<?php if(Yii::$app->controller->action->id === 'login'){?> class="active"<?php } ?>><a href="<?=Url::to(['site/login'])?>">ВОЙТИ</a></li>
                    <?php else : ?>
                    <li<?php if(Yii::$app->controller->action->id === 'profile'){?> class="active"<?php } ?> id="profile-btn">
                        <a href="<?=Url::to(['site/profile'])?>">ПРОФИЛЬ</a>
                        <ul id="profile-dropdown" class="z-depth-2">
                            <li><a href="<?=Url::to(['site/profile', 'action' => 'edit'])?>"><i class="material-icons left">settings</i>РЕДАКТИРОВАТЬ</a></li>
                            <li><a href="<?=Url::to(['site/logout'])?>"><i class="material-icons left">exit_to_app</i>ВЫЙТИ</a></li>
                        </ul>
                    </li>
                    <li id="notification-item" class="notification-btn-item">
                        <a class="notification-btn">
                            <i class="material-icons">notifications</i>
                            <?php if($this->params['hasUnreadNotifications']) : ?>
                                <div class="new-notifications z-depth-2 green"></div>
                            <?php endif ?>
                        </a>
                        <ul class="notification-list z-depth-3">
                            <?php if(count($this->params['notifications']) > 0):
                                foreach($this->params['notifications'] as $notification): ?>
                                    <li class="flex<?php if($notification->status == '0'): ?> unread-notification<?php endif ?>" data-id="<?= $notification->id ?>" style="justify-content: space-between">
                                        <span class="truncate"><?= $notification->text ?></span>
                                        <a class="clear-notification right tooltipped " data-position="left" data-tooltip="Скрыть"><i class="material-icons">clear</i></a>
                                    </li>
                                <?php endforeach;
                            else: ?>
                                <li>Нет уведомлений!</li>
                            <?php endif ?>
                        </ul>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>
    </div>
    <main>
        <?= $content ?>
    </main>
    <footer class="page-footer grey lighten-3 ">
        <div class="container">
            <div class="row flex">
                <div class="footer-left">
                    <h6 class="black-text">МЫ В СОЦИАЛЬНЫХ СЕТЯХ</h6>
                    <ul class="socials links">
                        <li class="vk z-depth-3"><a class="waves-effect waves-light" target="_blank" href="https://vk.com/volvo_trucks_russia"></a></li>
                        <li class="steam z-depth-3"><a class="waves-effect waves-light" target="_blank" href="http://steamcommunity.com/groups/volvo_trucks"></a></li>
                        <li class="instagram z-depth-3"><a class="waves-effect waves-light" target="_blank" href="https://instagram.com/volvo_trucks_russia"></a></li>
                        <li class="youtube z-depth-3"><a class="waves-effect waves-light" target="_blank" href="https://www.youtube.com/channel/UCCUkLXBObH0IA54XhCaDTzg"></a></li>
                    </ul>
                </div>
                <div class="footer-right">
                    <h6 class="black-text">ПОЛЕЗНЫЕ ССЫЛКИ</h6>
                    <ul class="links adds">
                        <li class="truckersmp"><a class="waves-effect" target="_blank" href="https://truckersmp.com/"></a></li>
                        <li class="scs"><a class="waves-effect" target="_blank" href="http://blog.scssoft.com/"></a></li>
                        <li class="ets"><a class="waves-effect" target="_blank" href="https://www.eurotrucksimulator2.com/"></a></li>
                        <li class="ats"><a class="waves-effect" target="_blank" href="http://www.americantrucksimulator.com/"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright grey lighten-2 black-text">
            <div class="container"><span>&copy; ВТК "VOLVO TRUCKS" - <?=date('Y')?></span></div>
        </div>
    </footer>
</div>
<?php if(\app\models\User::isAdmin()): ?>
    <script src="<?= Yii::$app->request->baseUrl ?>/assets/js/admin.js"></script>
<?php endif ?>
<?php if(Yii::$app->controller->action->id === 'news' || Yii::$app->controller->action->id === 'variations') : ?>
<script src="<?= Yii::$app->request->baseUrl ?>/assets/js/fotorama.js"></script>
<?php endif ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>