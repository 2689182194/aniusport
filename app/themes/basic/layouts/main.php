<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\web\View;
use app\themes\basic\ThemeAsset;

ThemeAsset::register($this);

//$this->registerCssFile('@web/css/style.css');

$moduleID = Yii::$app->controller->module->id;
if (!Yii::$app->user->isGuest) {
    $image = Yii::$app->user->identity->images == '' ? $this->theme->getAssetUrl('images/avatar-img.jpg') : Yii::getAlias('@web/uploads/member/'.Yii::$app->user->identity->images);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div style="display:none">
</div>
<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
