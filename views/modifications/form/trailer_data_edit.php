<h6 class="light" id="trailer-name" style="font-weight: bold;"><?= $trailer_data['name'] ?></h6>
<span class="light" id="trailer-description"><?= $trailer_data['description'] ?></span>
<img src="<?= Yii::$app->request->baseUrl . '/images/' . $trailer_data['image'] ?>" class="responsive-img z-depth-2" id="trailer-image" style="width: 100%;">