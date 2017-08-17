<?php


$this->title = 'Заявления Volvo Trucks';
?>

<div class="parallax-container" style="height: 400px;">
    <div class="container">
        <h4 class="parallax-title light white-text text-shadow">Заявления Volvo Trucks</h4>
    </div>
    <div class="parallax"><img src="<?=Yii::$app->request->baseUrl?>/assets/img/claims.jpg"></div>
</div>
<div class="container claims">
    <div class="row">
        <div class="col s12">
            <ul class="tabs tabs-fixed-width">
                <li class="tab">
                    <a href="#recruit">
                        На вступление
                        <?php if(\app\models\User::isAdmin()){
                            $count_recruits = \app\models\ClaimsFired::countClaims($recruits, true);
                            if($count_recruits > 0) : ?>
                                <span class="claims-count circle indigo darken-3 white-text"><?= $count_recruits ?></span>
                            <?php endif;
                        } ?>
                    </a>
                </li>
                <li class="tab"><a href="#dismissal">
                        На увольнение
                        <?php if(\app\models\User::isAdmin()){
                            $count_recruits = \app\models\ClaimsFired::countClaims($fired, true);
                            if($count_recruits > 0) : ?>
                                <span class="claims-count circle indigo darken-3 white-text"><?= $count_recruits ?></span>
                            <?php endif;
                        } ?>
                    </a>
                </li>
                <li class="tab"><a href="#nickname">
                        На смену ника
                        <?php if(\app\models\User::isAdmin()){
                            $count_recruits = \app\models\ClaimsFired::countClaims($nickname, true);
                            if($count_recruits > 0) : ?>
                                <span class="claims-count circle indigo darken-3 white-text"><?= $count_recruits ?></span>
                            <?php endif;
                        } ?>
                    </a>
                </li>
                <li class="tab"><a href="#vacation">
                        На отпуск
                        <?php if(\app\models\User::isAdmin()){
                            $count_recruits = \app\models\ClaimsFired::countClaims($vacation, true);
                            if($count_recruits > 0) : ?>
                                <span class="claims-count circle indigo darken-3 white-text"><?= $count_recruits ?></span>
                            <?php endif;
                        } ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php include_once 'claims/recruit.php' ?>
    <?php include_once 'claims/fired.php' ?>
    <?php include_once 'claims/nickname.php' ?>
    <?php include_once 'claims/vacation.php' ?>
</div>