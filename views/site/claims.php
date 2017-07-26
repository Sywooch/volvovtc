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
                <li class="tab col s3"><a href="#recruit">На вступление</a></li>
                <li class="tab col s3"><a href="#dismissal">На увольнение</a></li>
                <li class="tab col s3"><a href="#nickname">На смену ника</a></li>
                <li class="tab col s3"><a href="#vacation">На отпуск</a></li>
            </ul>
        </div>
    </div>
    <?php include_once 'claims/recruit.php' ?>
    <?php include_once 'claims/fired.php' ?>
    <?php include_once 'claims/nickname.php' ?>
    <?php include_once 'claims/vacation.php' ?>
</div>